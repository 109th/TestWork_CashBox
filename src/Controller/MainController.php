<?php

namespace App\Controller;

use App\CashBox\Interfaces\MetricsInterface;
use App\Modeling;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\ColumnChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\LineChart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainController
 * @package App\Controller
 */
class MainController extends AbstractController
{
    /**
     * @var MetricsInterface
     */
    protected $metrics;

    /**
     * @required
     * @param MetricsInterface $metrics
     */
    public function setMetrics(MetricsInterface $metrics): void
    {
        $this->metrics = $metrics;
    }

    /**
     * @Route("/")
     * @param Modeling $modeling
     * @return Response
     * @throws \Exception
     */
    public function indexAction(Modeling $modeling): Response
    {
        $modeling->do();

        $customerChart = new LineChart();
        $customerChart->getData()->setArrayToDataTable($this->metrics->getCustomerIncomeChartData());
        $customerChart->getOptions()->setTitle('Customers Income')
            ->setSeries([
                ['axis' => 'Counts'],
            ])
            ->setAxes(['y' => ['Counts' => ['label' => 'Customer Counts']]])
            ->setHeight(400)
            ->setWidth(900);

        $queueChart = new ColumnChart();
        $queueChart->getData()->setArrayToDataTable($this->metrics->getCashBoxQueueChartData());
        $queueChart->getOptions()->getChart()
            ->setTitle('CashBox Queue');
        $queueChart->getOptions()
            ->setBars('vertical')
            ->setHeight(400)
            ->setWidth(900)
            ->getVAxis()
            ->setFormat('decimal');

        $cashBoxTimeChart = new ColumnChart();
        $cashBoxTimeChart->getData()->setArrayToDataTable($this->metrics->getCashBoxTimeChartData());
        $cashBoxTimeChart->getOptions()->getChart()
            ->setTitle('CashBox Time (Seconds)');
        $cashBoxTimeChart->getOptions()
            ->setBars('vertical')
            ->setHeight(400)
            ->setWidth(900)
            ->getVAxis()
            ->setFormat('decimal');

        return $this->render('main/index.html.twig', [
            'customerChart' => $customerChart,
            'queueChart' => $queueChart,
            'cashBoxTimeChart' => $cashBoxTimeChart,
        ]);
    }
}
