<?php

namespace Faakolore\USSD\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
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
    protected $signature = 'make:ussd-adapter {name}';

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
     * @return mixed
     */
    public function handle()
    {
        $path = app()->path() . 'Http/USSD/Adapter/'.$this->argument('name');
        $fullPath = sprintf("%s/%s.php", $path, $this->argument('name'));

        if (file_exists($fullPath)) {
            $this->error('Adapter already exists!');
            die;
        }

        if (!is_dir($path)) mkdir($path);

        $this->writeToFile($fullPath);
        $this->writeToFactory();
        $this->info('Created adapter successfully.');
    }

    public function getRequestStub(): string
    {
        return __DIR__ . '../../stubs/Adapter/request.stub';
    }
    public function getResponseStub(): string
    {
        return __DIR__ . '../../stubs/Adapter/response.stub';
    }

    public function buildContents(): array
    {
        return $this->setContents()->replaceClassName()->replaceMessage()->build();
    }

    private function replaceMessage(): self
    {
        if ($this->option("message"))
            $this->contents = str_replace('{{message}}', $this->option('message'), $this->contents);

        return $this;
    }

    private function replaceClassName(): self
    {
        $this->contents = str_replace('{{class}}', $this->argument('name'), $this->contents);
        return $this;
    }

    private function setContents(): self
    {
        $this->contents = Arr::add($this->contents,'request',file_get_contents($this->getRequestStub()));
        $this->contents = Arr::add($this->contents,'response',file_get_contents($this->getResponseStub()));
        return $this;
    }

    private function build(): array
    {
        return $this->contents;
    }

    private function writeToFile(string $fullPath): void
    {
        file_put_contents($fullPath, $this->buildContents());
    }

    private function writeToFactory()
    {
        $adapter = Str::lower($this->argument('name'));

        $requestPath = app_path('USSD/Factory/RequestFactory.php');
        $responsePath = app_path('USSD/Factory/ResourceFactory.php');

        $requestFactory = file_get_contents($requestPath);
        $responseFactory = file_get_contents($responsePath);

        $searchField =Str::before(Str::after($requestFactory, 'switch (request()->route("adapter")) {'),'default:');

        $searchResponseField =Str::before(Str::after($responseFactory, 'switch (request()->route("adapter")) {'),'default:');

        if (! Str::contains($searchField, $adapter)){
            file_put_contents($requestPath,$this->buildRequest($adapter));
            file_put_contents($responsePath,$this->buildResponse($adapter));
        }
    }

    /**
     * @param $adapter
     * @return string
     */
    private function buildRequest($adapter): string
    {
        return "case ".$adapter.":\n return resolve(".app_path('Http/USSD/Adapter/').$this->argument('name')."Request::class);";
    }

    /**
     * @param $adapter
     * @return string
     */
    private function buildResponse($adapter) :string
    {
        return "case ".$adapter.":\n return resolve(".app_path('Http/USSD/Adapter/').$this->argument('name')."Response::class);";
    }
}
