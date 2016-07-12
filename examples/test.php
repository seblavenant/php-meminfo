<?php

class MaClass{}
class Test
{
    public function run()
    {
        $objetA = new MaClass();
	$objetB = new MaClass();
	$objetB->date = new \DateTime();

        $objetA->b = $objetB;	
	$objetB->a = $objetA;

	return $objetA;
    }
}

$leakHolder = [];
$count=0;
for($i=0; $i<20000; $i++)
{
    $test = new Test();
    $objet = $test->run();

    $leakHolder[] = $objet;

    echo sprintf("[%'.05d] Memory usage : %dMo\n", $count++, memory_get_peak_usage() / 1024 / 1024);
}

gc_collect_cycles();

# Nombre groupé par objet
meminfo_objects_summary(fopen('php://stdout','w'));
#
# Liste des instances
#meminfo_objects_list(fopen('php://stdout', 'w'));
#
# Dump
meminfo_info_dump(fopen('/tmp/dump.json', 'w'));
