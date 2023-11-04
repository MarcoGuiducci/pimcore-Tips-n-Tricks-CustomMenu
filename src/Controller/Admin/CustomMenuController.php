<?php

namespace App\Controller\Admin;

use Pimcore\Db;
use Symfony\Component\HttpFoundation\Request;
use Pimcore\Bundle\AdminBundle\Controller\AdminAbstractController;
use Pimcore\Bundle\ApplicationLoggerBundle\ApplicationLogger;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/custom-menu")
 */
class CustomMenuController extends AdminAbstractController
{
    /**
     * @var ApplicationLogger
     */
    protected $logger;
    
    public function __construct()
    {
        $this->logger = ApplicationLogger::getInstance();
    }

    /**
     * @Route("/create-awgMm2-row")
     */
    public function createAwgMmm2RowAction(Request $request)
    {
        $awg = $request->get("awg");
        $mm2 = $request->get("mm2");

        $db = Db::get();
        $query = "INSERT INTO `mm2_to_awg_conversion` (`mm2`, `awg`) VALUES ($mm2, '$awg' );";
        $db->executeQuery($query);
        
        $mm2AwgConversionValues = $db->fetchAllAssociative('SELECT * FROM mm2_to_awg_conversion');
        
        $mm2AwgValues = [];

        foreach ($mm2AwgConversionValues as $value) {
            $row = [
                'mm2' => $value["mm2"],
                'awg' => $value["awg"],
                'id' => $value["id"]
            ];

            $mm2AwgValues[] = $row;
        }

        return new Response(json_encode(["data" => $mm2AwgValues]));
    }

    /**
     * @Route("/delete-awgMm2-row", methods={"POST"})
     */
    public function deleteAwgMm2Action(Request $request)
    {
        $index = $request->get("rowId");
        $db = Db::getConnection();
        $query = "DELETE FROM `mm2_to_awg_conversion` WHERE id = $index";
        $db->executeQuery($query);
        $response = array('success' => true);

        return $this->adminJson($response);
    }

    /**
     * @Route("/get-custommenu-settings-attributes", name="get-custommenu-settings-attributes", methods={"GET"})
     *
     * @return array
     */
    public function getSettingsAttributesAction(Request $request)
    {
        $mm2AwgValues = [];

        $db = Db::get();
        $mm2AwgConversionValues = $db->fetchAllAssociative('SELECT * FROM mm2_to_awg_conversion');
        foreach ($mm2AwgConversionValues as $value) {
            $row = [
                'mm2' => $value["mm2"],
                'awg' => $value["awg"],
                'id' => $value["id"]
            ];
            
            $mm2AwgValues[] = $row;
        }

        $response = [
            "mm2AwgValues" => $mm2AwgValues,
        ];

        return $this->adminJson(["data" => $response]);
    }
    
    /**
     * @Route("/save-custommenu-settings-attributes", methods={"POST"})
     */
    public function saveSettingsAttributesAction(Request $request)
    {
        $mm2AwgValues = $request->get("mm2AwgValues");
        $mm2AwgSettings = json_decode($mm2AwgValues,true);

        $response = array('success' => true);

        $db = Db::get();

        foreach ($mm2AwgSettings as $mm2AwgRow) {
            $mm2 = $mm2AwgRow["mm2"];
            $awg = $mm2AwgRow["awg"];
            $id = $mm2AwgRow["id"];

            $query = "INSERT INTO mm2_to_awg_conversion (id,mm2, awg) VALUES($id, '$mm2', '$awg') ON DUPLICATE KEY UPDATE id=$id, mm2 = '$mm2', awg = '$awg'";
            $db->executeQuery($query);
        }

        return $this->adminJson($response);
    }
}
