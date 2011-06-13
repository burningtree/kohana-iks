<?php defined('SYSPATH') or die('No direct script access.');

class Iks {

    public static function boot($controller)
    {
        print "iks (Interactive Kohana Shell) [Kohana ".Kohana::VERSION." \"".Kohana::CODENAME."\"] [PHP ".phpversion()."]\n";
        print "Loaded application: ".getcwd()." \n";

        $on = TRUE;
        $c = 1;

        do {

            $last = NULL;
            print 'iks(main):'.str_pad($c, 3, "0", STR_PAD_LEFT).'> ';
            $c++;
            ob_flush();

            $cmd = trim(fgets(STDIN));
            if($cmd=='') continue;

            ob_start();
            ob_implicit_flush(TRUE);

            try {

                $cmd = (!preg_match("/^(do|for|function|class)/",$cmd) ? '$last=' : '' ) .$cmd.';';
                $start = microtime(TRUE);
                print eval($cmd);
                $end = microtime(TRUE);

                if(ob_get_contents()!="")
                {
                    print "\n";
                    ob_flush();
                }
                if(is_object($last))
                {
                    print "=> object(".get_class($last).") <".spl_object_hash($last).">\n\n";
                }
                else
                {
                    var_dump($last);
                    $dump = ob_get_contents();
                    ob_clean();
                    //print "=> ".str_replace(array("\n\n",""),array(" ", ""), $dump)."\n";
                    print "=> ".$dump."\n";
                }

                print Num::format(($end-$start), 3)."s ".Num::format(($end-$start)*1000, 3)."ms\n";
                ob_end_flush();

            }
            catch (ErrorException $e)
            {
                ob_end_flush();
                print get_class($e).": ".$e->getMessage()."\n\n";
            }
        } 
        while ($on);
    }
}
