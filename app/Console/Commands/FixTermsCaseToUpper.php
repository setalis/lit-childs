<?php

namespace App\Console\Commands;

use App\Models\Term;
use Illuminate\Console\Command;

class FixTermsCaseToUpper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'terms:fix-case-upper';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix the case of existing terms - make first letter uppercase';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fixing terms case to uppercase...');

        $terms = Term::all();
        
        $this->info('Current terms:');
        foreach ($terms as $term) {
            $this->line("  - '{$term->name}'");
        }
        
        $updated = 0;

        foreach ($terms as $term) {
            $originalName = $term->name;
            $fixedName = mb_strtoupper(mb_substr($term->name, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($term->name, 1, null, 'UTF-8');
            
            $this->line("Checking: '{$originalName}' -> '{$fixedName}'");
            
            if ($originalName !== $fixedName) {
                $term->update(['name' => $fixedName]);
                $this->line("Updated: '{$originalName}' -> '{$fixedName}'");
                $updated++;
            }
        }

        $this->info("Fixed {$updated} terms out of {$terms->count()} total terms.");
        
        return 0;
    }
}
