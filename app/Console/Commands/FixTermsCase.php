<?php

namespace App\Console\Commands;

use App\Models\Term;
use Illuminate\Console\Command;

class FixTermsCase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'terms:fix-case';

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
        $this->info('Fixing terms case...');

        $terms = Term::all();
        $updated = 0;

        foreach ($terms as $term) {
            $originalName = $term->name;
            $fixedName = ucfirst(mb_strtolower($term->name, 'UTF-8'));
            
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
