<?php

namespace Faakolore\USSD\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeUssdAdapter extends Command
{
    /**
     * @var array
     */
    private $contents;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:ussd-adapter {name} {--message=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new USSD adapter';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $path = app_path('Http/USSD/Adapter/'.$this->argument('name'));
        $requestFullPath = sprintf("%s/%s.php", $path, $this->argument('name').'Request');
        $responseFullPath = sprintf("%s/%s.php", $path, $this->argument('name').'Response');

        if (file_exists($requestFullPath) || file_exists($responseFullPath)) {
            $this->error('Adapter already exists!');
            die;
        }

        (new Filesystem)->ensureDirectoryExists($path);

        $this->writeToFile($requestFullPath,'request');
        $this->writeToFile($responseFullPath,'response');
        $this->writeToFactory();
        $this->info('Created adapter successfully.');
    }

    /**
     * @return string
     */
    public function getRequestStub(): string
    {
        return __DIR__ . '/../../stubs/Adapter/request.stub';
    }

    /**
     * @return string
     */
    public function getResponseStub(): string
    {
        return __DIR__ . '/../../stubs/Adapter/response.stub';
    }

    /**
     * @param string $type
     * @return string
     */
    public function buildContents(string $type): string
    {
        return $this->setContents($type)->replaceClassName()->replaceMessage()->build();
    }

    /**
     * @return $this
     */
    private function replaceMessage(): self
    {
        if ($this->option("message"))
            $this->contents = str_replace('{{message}}', $this->option('message'), $this->contents);

        return $this;
    }

    /**
     * @return $this
     */
    private function replaceClassName(): self
    {
        $this->contents = str_replace('{{class}}', $this->argument('name'), $this->contents);
        return $this;
    }

    /**
     * @param string $type
     * @return $this
     */
    private function setContents(string $type): self
    {
        $type == 'request'?
                $this->contents = file_get_contents($this->getRequestStub())
                :    $this->contents = file_get_contents($this->getResponseStub());
        return $this;
    }

    /**
     * @return string
     */
    private function build(): string
    {
        return $this->contents;
    }

    private function writeToFile(string $fullPath, string $type): void
    {
        file_put_contents($fullPath, $this->buildContents($type));
    }

    private function writeToFactory()
    {
        $adapter = Str::lower($this->argument('name'));

        $requestPath = app_path('USSD/Factory/RequestFactory.php');
        $responsePath = app_path('USSD/Factory/ResponseFactory.php');

        $requestFactory = file_get_contents($requestPath);
        $responseFactory = file_get_contents($responsePath);

        $searchField =Str::before(Str::after($requestFactory, "switch (request()->route('adapter')) {"),'default:');
        $searchResponseField =Str::before(Str::after($responseFactory, "switch (request()->route('adapter')) {"),'default:');

        $after = "switch (request()->route('adapter')) {";
        if (! Str::contains($searchField, $adapter)){
            $modifiedRequest = str_replace(
                $after,
                $after.PHP_EOL.$this->buildRequest($adapter),
                $requestFactory
            );
            $modifiedResponse = str_replace(
                $after,
                $after.PHP_EOL.$this->buildResponse($adapter),
                $responseFactory
            );
            file_put_contents($requestPath,$modifiedRequest);
            file_put_contents($responsePath,$modifiedResponse);
        }
    }

    /**
     * @param $adapter
     * @return string
     */
    private function buildRequest($adapter): string
    {
        return "case "."'".$adapter."'".":\n return resolve(\App\Http\USSD\Adapter\\".$this->argument('name')."\\".$this->argument('name')."Request::class);";
    }

    /**
     * @param $adapter
     * @return string
     */
    private function buildResponse($adapter) :string
    {
        return "case "."'".$adapter."'".":\n return resolve(\App\Http\USSD\Adapter\\".$this->argument('name')."\\".$this->argument('name')."Response::class);";
    }
}
