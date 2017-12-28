<?php namespace App\Console\Commands;

use Illuminate\Console\Command;

class Translate extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'translation:add {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add translations to modules.';

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
        $module = $this->argument('module');
        //get translation folders
        $languages = array_diff(scandir('resources/lang'), array('..', '.'));
        $_language = 'App\\Admin\\Creators\\Language';
        $language = new $_language($module);
        $en = $this->ask('Enter the default \'en\' translation:');
        //check if default english translation exists
        if(\Lang::has($module.'.'.$en)){
            $this->error('The translation for '.$en.' already exists.');
        }else{
            $language->add('en',$en,$en);
            foreach($languages as $lang){
                if($lang != 'en'){
                    $trans = $this->ask('Enter the \''.$lang.'\' translation:');
                    $language->add($lang,$en,$trans);
                }
            }
        }
    }


}
