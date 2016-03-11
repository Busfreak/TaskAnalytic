<?php

namespace Kanboard\Plugin\TaskAnalytic;

use Kanboard\Core\Plugin\Base;

class Plugin extends Base
{
    public function initialize()
    {

        $this->template->setTemplateOverride('analytic/tasks', 'TaskAnalytic:analytic/tasks');
#        $this->template->setTemplateOverride('analytic/TaskDistributionAnalytic', 'TaskDistributionAnalytic:analytic/TaskDistributionAnalytic');
#        $this->template->hook->attach('template:project:sidebar', 'color_filter:project/sidebar');
    }

    public function getClasses()
    {
        return array(
            'Plugin\TaskAnalytic\Controller' => array(
                'TaskDistributionAnalytic',
            ),
            'Plugin\TaskAnalytic\Analytic' => array(
                'TaskDistributionAnalytic',
            ),
        );
    }

    public function getPluginName()
    {
        return 'TaskDistributionAnalytic';
    }

    public function getPluginDescription()
    {
        return t('Additional Analytics for TaskDistribution');
    }

    public function getPluginAuthor()
    {
        return 'Martin Middeke';
    }

    public function getPluginVersion()
    {
        return '0.0.1';
    }

	    public function getPluginHomepage()
    {
        return 'https://github.com/Busfreak/kanboard-TaskDistributionAnalytic';
    }
}