<?php


namespace Faakolore\USSD\Http;

use App\USSD\Screens\Welcome;
use Illuminate\Http\Request as BaseRequest;
use App\USSD\Factory\RequestFactory;
use Faakolore\USSD\Models\Session;
use Faakolore\USSD\Screen;

class Request extends BaseRequest
{
    const INITIAL = 1, RESPONSE = 2, RELEASE = 3, TIMEOUT = 4;
    public $msisdn;
    public $session;
    public $type;
    /**
     * @var string $message
     */
    public $message;
    /**
     * @var Session
     */
    public $trail;

    /**
     * @var bool $valid whether the request is valid XML document or not
     */
    private $valid = false;

    /**
     * @var bool $validJson whether the request is valid json or not
     */
    private $validJson = false;

    public function __construct()
    {
        parent::__construct();
        $this->setProperties((new RequestFactory())->make());

        if ($this->invalidJson() || $this->invalid()) return;

        $this->setSessionLocale();
        $this->trail = $this->getTrail();
    }

    public function toPreviousScreen(): bool
    {
        return $this->message == Screen::PREVIOUS;
    }

    public function toHomeScreen(): bool
    {
        if ($this->getExistingSession()) return false;
        return $this->isInitial() || $this->message == Screen::HOME;
    }

    public function invalid(): bool
    {
        return !$this->valid;
    }
    public function invalidJson():bool
    {
        return !$this->validJson;
    }

    private function setValid(UssdRequestInterface $request): void
    {
        if (!$request) {
            $this->valid = false;
            $this->validJson = false;
            return;
        }

        $this->validJson = !empty($request->getMsisdn()) &&
            !empty($request->getSession()) &&
            !empty($request->getType()) &&
            !empty($request->getMessage());
        $this->valid = $this->validJson;
    }

    private function setProperties(UssdRequestInterface $request): void
    {
        $this->setValid($request);

        if ($this->validJson || $this->valid) {
            $this->msisdn = $request->getMsisdn();
            $this->session = $request->getSession();
            $this->type = $request->getType();
            $this->message = $request->getMessage();
        }
    }

    private function setSessionLocale(): void
    {
        if (Session::notCreated($this->session)) return;

        $session = Session::findBySessionId($this->session);
        app()->setLocale($session->{'locale'});
    }

    public function isInitial(): bool
    {
        return $this->type == self::INITIAL;
    }

    public function isResponse(): bool
    {
        return $this->type == self::RESPONSE;
    }

    public function isTimeout(): bool
    {
        return $this->type == self::TIMEOUT;
    }

    public function isReleased(): bool
    {
        return $this->type == self::RELEASE;
    }

    public function isNotUserResponse(): bool
    {
        return $this->isInitial() || $this->isTimeout() || $this->isReleased();
    }

    public function isNotReleased(): bool
    {
        return !$this->isReleased();
    }

    public function isNotTimeout(): bool
    {
        return !$this->isTimeout();
    }

    private function getTrail(): Session
    {
        $existingSession = $this->getExistingSession();
        if ($existingSession) return $existingSession->updateSessionId($this->session);

        return Session::firstOrCreate(
            ['session_id' => $this->session],
            ['state' => Welcome::class, 'msisdn' => $this->msisdn]
        );
    }

    public function getScreen(): Screen
    {
        return new $this->trail->{'state'}($this);
    }

    public function getPreviousScreen(): Screen
    {
        return $this->getScreen()->previous();
    }

    public function getExistingSession(): ?Session
    {
        return Session::recentSessionByPhone($this->msisdn);
    }
}
