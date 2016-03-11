<?php

namespace Kanboard\Plugin\TaskAnalytic\Analytic;

use Kanboard\Core\Base;

/**
 * Task Distribution
 *
 * @package  analytic
 * @author   Frederic Guillot
 */
class TaskDistributionAnalytic extends Base
{

    public function getSwimlanes(){
        return 'HALLO';
    }

    /**
     * Build report
     *
     * @access public
     * @param  integer   $project_id    Project id
     * @return array
     */
    public function build($project_id)
    {
        $metrics = array();
        $project = $this->request->getIntegerParam('project');
        $swimlane_id = $this->request->getIntegerParam('swimlane_id');
        $closedtasks = $this->taskFinder->getAll($project_id, 0);
        $total = 0;
        $closedtotal = 0;
        $closedcount = 0;
        $columns = $this->board->getColumns($project_id);
        $swimlanes = $this->swimlane->getAll($project_id);
        if ($swimlane_id > 0){
            foreach ($closedtasks as $closedtask) {
                $closedcount += ($closedtask['swimlane_id'] == $swimlane_id) ? 1 : 0;
            }
        }
        else
        {
            $closedcount = count($closedtasks);
        }    

        foreach ($columns as $column) {
            if ($swimlane_id === 0) {
                $nb_tasks = $this->taskFinder->countByColumnId($project_id, $column['id']);
            }
            else
            {
                $nb_tasks = $this->taskFinder->countByColumnAndSwimlaneId($project_id, $column['id'], $swimlane_id);
            }

            $total += $nb_tasks;
            $closedtotal += $nb_tasks;

            $metrics[] = array(
                'column_title' => $column['title'],
                'nb_tasks' => $nb_tasks,
            );
        }

        $closedtotal += $closedcount;
        $closedpercentage = round(($closedcount * 100) / $closedtotal, 2);
        $metrics[] = array(
            'column_title' => t('Closed'),
            'nb_tasks' => $closedcount . '/' . $closedtotal,
        );

        if ($total === 0) {
            return array();
        }

        foreach ($metrics as &$metric) {
            $metric['percentage'] = round(($metric['nb_tasks'] * 100) / $total, 2);
        }
        $metric['percentage'] = round(($closedcount * 100) / $closedtotal, 2);

        return $metrics;
    }
}
