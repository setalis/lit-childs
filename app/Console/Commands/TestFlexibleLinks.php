<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FigureLinkService;

class TestFlexibleLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:flexible-links {--word=} {--text=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Тестує гнучку систему автоматичних посилань';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = app(FigureLinkService::class);
        
        if ($this->option('word')) {
            $this->testWord($service, $this->option('word'));
        } elseif ($this->option('text')) {
            $this->testText($service, $this->option('text'));
        } else {
            $this->runDefaultTests($service);
        }
    }

    private function testWord(FigureLinkService $service, string $word)
    {
        $this->info("Тестування слова: {$word}");
        
        // Используем reflection для доступа к приватным методам
        $reflection = new \ReflectionClass($service);
        
        $generateVariantsMethod = $reflection->getMethod('generateWordVariants');
        $generateVariantsMethod->setAccessible(true);
        
        $createPatternMethod = $reflection->getMethod('createFlexiblePattern');
        $createPatternMethod->setAccessible(true);
        
        $variants = $generateVariantsMethod->invoke($service, $word);
        $pattern = $createPatternMethod->invoke($service, $word);
        
        $this->line("Варіанти слова:");
        foreach ($variants as $variant) {
            $this->line("  - {$variant}");
        }
        
        $this->line("Паттерн пошуку: {$pattern}");
    }

    private function testText(FigureLinkService $service, string $text)
    {
        $this->info("Тестування тексту:");
        $this->line("Оригінальний текст: {$text}");
        
        $processed = $service->processText($text);
        $this->line("Оброблений текст: {$processed}");
    }

    private function runDefaultTests(FigureLinkService $service)
    {
        $this->info("Запуск стандартних тестів гнучкої системи посилань");
        
        $testCases = [
            'Шевченко' => 'Творчість Шевченка справила вплив. Про Шевченка говорять. Шевченком захоплюються.',
            'література' => 'Література є важливою. Про літературу говорять. Літературою захоплюються.',
            'ШЕВЧЕНКО' => 'ШЕВЧЕНКО був поетом. шевченко писав вірші. Шевченко створив твори.',
        ];
        
        foreach ($testCases as $word => $text) {
            $this->newLine();
            $this->info("=== Тест для слова: {$word} ===");
            $this->line("Текст: {$text}");
            
            $processed = $service->processText($text);
            $this->line("Результат: {$processed}");
        }
        
        $this->newLine();
        $this->info("Тестування HTML контенту:");
        $htmlText = '<p>Творчість <strong>Тараса Шевченка</strong> справила вплив. Про <em>Шевченка</em> говорять.</p>';
        $this->line("HTML: {$htmlText}");
        
        $processedHtml = $service->processHtml($htmlText);
        $this->line("Результат: {$processedHtml}");
    }
} 