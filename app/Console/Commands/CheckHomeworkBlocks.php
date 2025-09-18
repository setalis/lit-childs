<?php

namespace App\Console\Commands;

use App\Models\BlockElement;
use App\Models\HomeworkBlock;
use Illuminate\Console\Command;

class CheckHomeworkBlocks extends Command
{
    protected $signature = 'check:homework-blocks';
    
    protected $description = 'Check homework blocks and their elements';

    public function handle(): void
    {
        $this->info('Checking homework blocks...');
        
        // Проверяем блоки домашних заданий
        $homeworkBlocks = HomeworkBlock::all();
        $this->info("Found {$homeworkBlocks->count()} homework blocks");
        
        foreach ($homeworkBlocks as $block) {
            $this->info("Homework Block ID: {$block->id}");
            
            // Проверяем элементы этого блока
            $elements = BlockElement::where('block_elementable_type', 'App\Models\HomeworkBlock')
                ->where('block_elementable_id', $block->id)
                ->get();
            
            $this->info("  Elements: {$elements->count()}");
            
            foreach ($elements as $element) {
                $this->info("    Element ID: {$element->id}, Type: {$element->element_type}");
                $this->info("    Is from control/homework block: " . ($element->isFromControlBlock() ? 'YES' : 'NO'));
                
                if (!empty($element->content)) {
                    $processed = $element->processed_content;
                    $hasAnyLinks = strpos($processed, '<a href=') !== false;
                    $hasInternalLinks = strpos($processed, 'href="/figures/') !== false || strpos($processed, 'href="/terms/') !== false;
                    $hasExternalLinks = strpos($processed, 'href="http') !== false;
                    
                    $this->info("    Has any links: " . ($hasAnyLinks ? 'YES' : 'NO'));
                    $this->info("    Has internal links (figures/terms): " . ($hasInternalLinks ? 'YES' : 'NO'));
                    $this->info("    Has external links: " . ($hasExternalLinks ? 'YES' : 'NO'));
                    
                    if ($hasInternalLinks) {
                        $this->warn("    WARNING: Internal links found in homework block element!");
                        $this->info("    Full content: " . $element->content);
                        $this->info("    Full processed: " . $processed);
                    } elseif ($hasExternalLinks) {
                        $this->info("    ✓ Only external links (manually added) - working correctly!");
                    } else {
                        $this->info("    ✓ No links - working correctly!");
                    }
                }
            }
        }
        
        // Проверяем все элементы блоков домашних заданий
        $allHomeworkElements = BlockElement::where('block_elementable_type', 'App\Models\HomeworkBlock')->get();
        $this->info("\nTotal homework block elements: {$allHomeworkElements->count()}");
        
        // Проверяем другие элементы для сравнения
        $otherElements = BlockElement::whereNotIn('block_elementable_type', [
            'App\Models\ControlBlock',
            'App\Models\HomeworkBlock'
        ])->get();
        $this->info("Other elements: {$otherElements->count()}");
    }
}