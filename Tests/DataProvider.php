<?php
/*
 * This file is part of the SofHad package.
 *
 * (c) Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace So\LogboardBundle\Tests;


/**
 * Data Provider
 *
 * @author Sofiane HADDAG <sofiane.haddag@yahoo.fr>
 */
class DataProvider
{

    const SYMFONY_PATTERN_DATE = '/^\[([0-9]{4}-[[0-9]{2}-[[0-9]{2}).*/';
    const TESTS_LOG_FILE = '/app/logs/unit_testing_logs.log';

    public static function getTestsLogFilePath(){
        return __DIR__.self::TESTS_LOG_FILE;
    }

    public function unrefinedProfilerData()
    {
        $data = array();

        $data[0] = array(
            "timestamp" => 1381501307,
            "message" => 'Notified event "kernel.controller" to listener "Symfony\Bundle\FrameworkBundle\DataCollector\RouterDataCollector::onKernelController',
            "priority" => 100,
            "priorityName" => 'DEBUG',
            "context" => array()
        );

        $data[1] = array(
            "timestamp" => 1381760507,
            "message" => 'Notified event "kernel.controller" to listener "Sensio\Bundle\FrameworkExtraBundle\EventListener\TemplateListener::onKernelController',
            "priority" => 100,
            "priorityName" => 'DEBUG',
            "context" => array()
        );

        $data[2] = array(
            "timestamp" => 1381933307,
            "message" => 'Notified event "kernel.response" to listener "Symfony\Component\HttpKernel\EventListener\ResponseListener::onKernelResponse',
            "priority" => 100,
            "priorityName" => 'DEBUG',
            "context" => array()
        );

        $data[3] = array(
            "timestamp" => 1381933307,
            "message" => 'Notified event "kernel.response" to listener "Symfony\Component\HttpKernel\EventListener\LocaleListener::onKernelResponse',
            "priority" => 100,
            "priorityName" => 'DEBUG',
            "context" => array()
        );

        $data[4] = array(
            "timestamp" => 1381933414,
            "message" => 'SELECT t0.id AS id1, t0.soc_nom AS soc_nom2, t0.soc_num_siret AS soc_num_siret3, t0.soc_adres_cp AS soc_adres_cp4, t0.soc_pays AS soc_pays5, t0.pers_civilite AS pers_civilite6, t0.pers_nom AS pers_nom7, t0.pers_prenom AS pers_prenom8, t0.pers_email AS pers_email9, t0.pers_tel AS pers_tel10, t0.pers_mobile AS pers_mobile11, t0.cdate AS cdate12, t0.id_soc AS id_soc13 FROM quotation_societe t0 WHERE t0.id_soc = ? [2849] []',
            "priority" => 100,
            "priorityName" => 'DEBUG',
            "context" => array()
        );

        $data[5] = array(
            "timestamp" => 1382365307,
            "message" => 'event.DEBUG: Notified event "kernel.request" to listener "Symfony\Component\Security\Http\Firewall::onKernelRequest',
            "priority" => 100,
            "priorityName" => 'DEBUG',
            "context" => array()
        );

        $data[6] = array(
            "timestamp" => 1382451707,
            "message" => 'app.INFO: Debut du service SOAP quotation',
            "priority" => 200,
            "priorityName" => 'INFO',
            "context" => array()
        );

        $data[7] = array(
            "timestamp" => 1382624507,
            "message" => 'Notified event "kernel.request" to listener "Symfony\Bundle\FrameworkBundle\EventListener\SessionListener::onKernelRequest',
            "priority" => 100,
            "priorityName" => 'DEBUG',
            "context" => array()
        );

        $data[8] = array(
            "timestamp" => 1382973707,
            "message" => 'Notified event "kernel.request" to listener "Symfony\Component\HttpKernel\EventListener\FragmentListener::onKernelRequest',
            "priority" => 100,
            "priorityName" => 'DEBUG',
            "context" => array()
        );

        $data[9] = array(
            "timestamp" => 1382973707,
            "message" => 'Notified event "kernel.request" to listener "Symfony\Component\HttpKernel\EventListener\LocaleListener::onKernelRequest',
            "priority" => 100,
            "priorityName" => 'DEBUG',
            "context" => array()
        );

        $data[10] = array(
            "timestamp" => 1382973707,
            "message" => 'Notified event "kernel.request" to listener "Core\BaseBundle\EventListener\DoctrineExtensionListener::onKernelRequest',
            "priority" => 100,
            "priorityName" => 'DEBUG',
            "context" => array()
        );

        $data[11] = array(
            "timestamp" => 1382973707,
            "message" => 'Notified event "kernel.controller" to listener "Core\BaseBundle\EventListener\autoloadingListener::onKernelController',
            "priority" => 100,
            "priorityName" => 'DEBUG',
            "context" => array()
        );

        $data[12] = array(
            "timestamp" => 1382973707,
            "message" => 'Notified event "kernel.response" to listener "Symfony\Bridge\Monolog\Handler\FirePHPHandler::onKernelResponse',
            "priority" => 100,
            "priorityName" => 'DEBUG',
            "context" => array()
        );

        $data[13] = array(
            "timestamp" => 1382973707,
            "message" => 'Uncaught PHP Exception So\LogboardBundle\Exception\BadQueryHttpException: "The specified Logboard engine "logboard.file_storage_php_date_1" does not exist or is not configured correctly" at C:\xampp\htdocs\BeautyLogBundle\Symfony.2.4\src\So\LogboardBundle\Controller\ProfilerController.php line 94 {"exception":"[object] (So\\LogboardBundle\\Exception\\BadQueryHttpException: The specified Logboard engine \"logboard.file_storage_php_date_1\" does not exist or is not configured correctly at C:\\xampp\\htdocs\\BeautyLogBundle\\Symfony.2.4\\src\\So\\LogboardBundle\\Controller\\ProfilerController.php:94)"}',
            "priority" => 400,
            "priorityName" => 'ERROR',
            "context" => array()
        );

        $data[14] = array(
            "timestamp" => 1382973707,
            "message" => 'Notified event "kernel.request" to listener "Core\BaseBundle\EventListener\DoctrineExtensionListener::onKernelRequest',
            "priority" => 100,
            "priorityName" => 'DEBUG',
            "context" => array()
        );

        $data[15] = array(
            "timestamp" => 1382973708,
            "message" => 'SELECT t0.id AS id1, t0.id_banq AS id_banq2, t0.holder AS holder3, t0.banq_code_banque AS banq_code_banque4, t0.banq_code_guichet AS banq_code_guichet5, t0.banq_num_compte AS banq_num_compte6, t0.banq_cle AS banq_cle7, t0.emandate_debtorId AS emandate_debtorId8, t0.emandate_rum AS emandate_rum9, t0.type AS type10, t0.payment_mode AS payment_mode11, t0.banq_nom AS banq_nom12, t0.banq_rue AS banq_rue13, t0.banq_addr_compl AS banq_addr_compl14, t0.banq_zip_code AS banq_zip_code15, t0.banq_ville AS banq_ville16, t0.banq_pays AS banq_pays17, t0.banq_bic AS banq_bic18, t0.banq_iban AS banq_iban19, t0.c_date AS c_date20, t0.v_date AS v_date21, t0.u_date AS u_date22, t0.id_soc AS id_soc23 FROM user_banque t0 WHERE t0.id_soc = ? [2849]',
            "priority" => 100,
            "priorityName" => 'DEBUG',
            "context" => array()
        );

        $data[16] = array(
            "timestamp" => 1382973814,
            "message" => 'SELECT t0.id AS id1, t0.id_banq AS id_banq2, t0.holder AS holder3, t0.banq_code_banque AS banq_code_banque4, t0.banq_code_guichet AS banq_code_guichet5, t0.banq_num_compte AS banq_num_compte6, t0.banq_cle AS banq_cle7, t0.emandate_debtorId AS emandate_debtorId8, t0.emandate_rum AS emandate_rum9, t0.type AS type10, t0.payment_mode AS payment_mode11, t0.banq_nom AS banq_nom12, t0.banq_rue AS banq_rue13, t0.banq_addr_compl AS banq_addr_compl14, t0.banq_zip_code AS banq_zip_code15, t0.banq_ville AS banq_ville16, t0.banq_pays AS banq_pays17, t0.banq_bic AS banq_bic18, t0.banq_iban AS banq_iban19, t0.c_date AS c_date20, t0.v_date AS v_date21, t0.u_date AS u_date22, t0.id_soc AS id_soc23 FROM user_banque t0 WHERE t0.id_soc = ? [2849]',
            "priority" => 100,
            "priorityName" => 'DEBUG',
            "context" => array()
        );

        $data[17] = array(
            "timestamp" => 1382973814,
            "message" => 'SELECT t0.product_id AS product_id1, t0.category AS category2, t0.name AS name3, t0.isvalid AS isvalid4, t0.s_desc AS s_desc5, t0.description AS description6, t0.childs AS childs7, t0.suspended AS suspended8, t0.cgv AS cgv9, t0.isvalid_cgv AS isvalid_cgv10, t0.demo AS demo11, t0.presentation_produit_checkbox AS presentation_produit_checkbox12, t0.presentation_produit AS presentation_produit13, t0.connect AS connect14, t0.url AS url15, t0.screenshot_url AS screenshot_url16, t0.video_url AS video_url17, t0.pdf_url AS pdf_url18, t0.ii_id_soc AS ii_id_soc19, t0.fft AS fft20, t0.fft_visibility AS fft_visibility21, t0.landing_page_box AS landing_page_box22, t0.slider_intro AS slider_intro23, t0.ordering AS ordering24, t0.c_date AS c_date25, t0.u_date AS u_date26, t0.editor_id AS editor_id27 FROM products t0 WHERE t0.product_id = ? [82]',
            "priority" => 100,
            "priorityName" => 'DEBUG',
            "context" => array()
        );

        $data[18] = array(
            "timestamp" => 1382973814,
            "message" => 'SELECT t0.id AS id1, t0.sender_is AS sender_is2, t0.message AS message3, t0.udate AS udate4, t0.quotation AS quotation5 FROM quotation_message t0 WHERE t0.quotation = ? [24] ',
            "priority" => 100,
            "priorityName" => 'DEBUG',
            "context" => array()
        );

        $data[19] = array(
            "timestamp" => 1382973814,
            "message" => 'SELECT t0.id AS id1, t0.service AS service2, t0.description AS description3, t0.mens AS mens4, t0.fpremc AS fpremc5, t0.fparc AS fparc6, t0.fparl AS fparl7, t0.udate AS udate8, t0.quantity AS quantity9, t0.quotation_id AS quotation_id10 FROM quotation_data t0 WHERE t0.quotation_id = ? [24]',
            "priority" => 100,
            "priorityName" => 'DEBUG',
            "context" => array()
        );

        return $data;
    }

    public function refinedDataWithPriorityKey()
    {
        return array
        (
            0 => array
            (
                'key' => 'DEBUG',
                'value' => '[2013 16:21:47] event.DEBUG: Notified event "kernel.controller" to listener "Symfony\Bundle\FrameworkBundle\DataCollector\RouterDataCollector::onKernelController".'
            ),

            1 => array
            (
                'key' => 'DEBUG',
                'value' => '[2013-10-14 16:21:47] event.DEBUG: Notified event "kernel.controller" to listener "Sensio\Bundle\FrameworkExtraBundle\EventListener\TemplateListener::onKernelController".'
            ),

            2 => array
            (
                'key' => 'DEBUG',
                'value' => '[2013-10-16 16:21:47] event.DEBUG: Notified event "kernel.response" to listener "Symfony\Component\HttpKernel\EventListener\ResponseListener::onKernelResponse".'
            ),

            3 => array
            (
                'key' => 'DEBUG',
                'value' => '[2013-10-16 16:21:47] event.DEBUG: Notified event "kernel.response" to listener "Symfony\Component\HttpKernel\EventListener\LocaleListener::onKernelResponse".'
            ),

            4 => array
            (
                'key' => 'DEBUG',
                'value' => '[2013-10-16 16:23:34] doctrine.DEBUG: SELECT t0.id AS id1, t0.soc_nom AS soc_nom2, t0.soc_num_siret AS soc_num_siret3, t0.soc_adres_cp AS soc_adres_cp4, t0.soc_pays AS soc_pays5, t0.pers_civilite AS pers_civilite6, t0.pers_nom AS pers_nom7, t0.pers_prenom AS pers_prenom8, t0.pers_email AS pers_email9, t0.pers_tel AS pers_tel10, t0.pers_mobile AS pers_mobile11, t0.cdate AS cdate12, t0.id_soc AS id_soc13 FROM quotation_societe t0 WHERE t0.id_soc = ? [2849]'
            ),

            5 => array
            (
                'key' => 'DEBUG',
                'value' => '[2013-10-21 16:21:47] event.DEBUG: Notified event "kernel.request" to listener "Symfony\Component\Security\Http\Firewall::onKernelRequest".'
            ),

            6 => array
            (
                'key' => 'DEBUG',
                'value' => '[2013-10-22 16:21:47] event.DEBUG: Notified event "kernel.request" to listener "Symfony\Component\HttpKernel\Fragment\FragmentHandler::onKernelRequest".'
            ),

            7 => array
            (
                'key' => 'INFO',
                'value' => '[2013-10-24 16:21:47] app.INFO: Debut du service SOAP quotation'
            ),

            8 => array
            (
                'key' => 'DEBUG',
                'value' => '[2013-10-28 16:21:47] event.DEBUG: Notified event "kernel.request" to listener "Symfony\Bundle\FrameworkBundle\EventListener\SessionListener::onKernelRequest".'
            ),

            9 => array
            (
                'key' => 'DEBUG',
                'value' => '[2013-10-28 16:21:47] event.DEBUG: Notified event "kernel.request" to listener "Symfony\Component\HttpKernel\EventListener\FragmentListener::onKernelRequest".'
            ),

            10 => array
            (
                'key' => 'DEBUG',
                'value' => '[2013-10-28 16:21:47] event.DEBUG: Notified event "kernel.request" to listener "Symfony\Component\HttpKernel\EventListener\LocaleListener::onKernelRequest".'
            ),

            11 => array
            (
                'key' => 'DEBUG',
                'value' => '[2013-10-28 16:21:47] event.DEBUG: Notified event "kernel.request" to listener "Core\BaseBundle\EventListener\DoctrineExtensionListener::onKernelRequest".'
            ),

            12 => array
            (
                'key' => 'DEBUG',
                'value' => '[2013-10-28 16:21:47] event.DEBUG: Notified event "kernel.controller" to listener "Core\BaseBundle\EventListener\autoloadingListener::onKernelController".'
            ),

            13 => array
            (
                'key' => 'DEBUG',
                'value' => '[2013-10-28 16:21:47] event.DEBUG: Notified event "kernel.response" to listener "Symfony\Bridge\Monolog\Handler\FirePHPHandler::onKernelResponse".'
            ),

            14 => array
            (
                'key' => 'ERROR',
                'value' => '[2013-10-28 16:21:47] request.ERROR: Uncaught PHP Exception So\LogboardBundle\Exception\BadQueryHttpException: "The specified Logboard engine "logboard.file_storage_php_date_1" does not exist or is not configured correctly" at C:\xampp\htdocs\BeautyLogBundle\Symfony.2.4\src\So\LogboardBundle\Controller\ProfilerController.php line 94 {"exception":"[object] (So\\LogboardBundle\\Exception\\BadQueryHttpException: The specified Logboard engine \"logboard.file_storage_php_date_1\" does not exist or is not configured correctly at C:\\xampp\\htdocs\\BeautyLogBundle\\Symfony.2.4\\src\\So\\LogboardBundle\\Controller\\ProfilerController.php:94)"}'
            ),

            15 => array
            (
                'key' => 'DEBUG',
                'value' => '[2013-10-28 16:21:48] event.DEBUG: Notified event "kernel.request" to listener "Core\BaseBundle\EventListener\DoctrineExtensionListener::onKernelRequest".'
            ),

            16 => array
            (
                'key' => 'DEBUG',
                'value' => '[2013-10-28 16:23:34] doctrine.DEBUG: SELECT t0.id AS id1, t0.id_banq AS id_banq2, t0.holder AS holder3, t0.banq_code_banque AS banq_code_banque4, t0.banq_code_guichet AS banq_code_guichet5, t0.banq_num_compte AS banq_num_compte6, t0.banq_cle AS banq_cle7, t0.emandate_debtorId AS emandate_debtorId8, t0.emandate_rum AS emandate_rum9, t0.type AS type10, t0.payment_mode AS payment_mode11, t0.banq_nom AS banq_nom12, t0.banq_rue AS banq_rue13, t0.banq_addr_compl AS banq_addr_compl14, t0.banq_zip_code AS banq_zip_code15, t0.banq_ville AS banq_ville16, t0.banq_pays AS banq_pays17, t0.banq_bic AS banq_bic18, t0.banq_iban AS banq_iban19, t0.c_date AS c_date20, t0.v_date AS v_date21, t0.u_date AS u_date22, t0.id_soc AS id_soc23 FROM user_banque t0 WHERE t0.id_soc = ? [2849] '
            ),

            17 => array
            (
                'key' => 'DEBUG',
                'value' => '[2013-10-28 16:23:34] doctrine.DEBUG: SELECT t0.product_id AS product_id1, t0.category AS category2, t0.name AS name3, t0.isvalid AS isvalid4, t0.s_desc AS s_desc5, t0.description AS description6, t0.childs AS childs7, t0.suspended AS suspended8, t0.cgv AS cgv9, t0.isvalid_cgv AS isvalid_cgv10, t0.demo AS demo11, t0.presentation_produit_checkbox AS presentation_produit_checkbox12, t0.presentation_produit AS presentation_produit13, t0.connect AS connect14, t0.url AS url15, t0.screenshot_url AS screenshot_url16, t0.video_url AS video_url17, t0.pdf_url AS pdf_url18, t0.ii_id_soc AS ii_id_soc19, t0.fft AS fft20, t0.fft_visibility AS fft_visibility21, t0.landing_page_box AS landing_page_box22, t0.slider_intro AS slider_intro23, t0.ordering AS ordering24, t0.c_date AS c_date25, t0.u_date AS u_date26, t0.editor_id AS editor_id27 FROM products t0 WHERE t0.product_id = ? [82] '
            ),

            18 => array
            (
                'key' => 'DEBUG',
                'value' => '[2013-10-28 16:23:34] doctrine.DEBUG: SELECT t0.id AS id1, t0.sender_is AS sender_is2, t0.message AS message3, t0.udate AS udate4, t0.quotation AS quotation5 FROM quotation_message t0 WHERE t0.quotation = ? [24] '
            ),

            19 => array
            (
                'key' => 'DEBUG',
                'value' => '[2013-10-28 16:23:34] doctrine.DEBUG: SELECT t0.id AS id1, t0.service AS service2, t0.description AS description3, t0.mens AS mens4, t0.fpremc AS fpremc5, t0.fparc AS fparc6, t0.fparl AS fparl7, t0.udate AS udate8, t0.quantity AS quantity9, t0.quotation_id AS quotation_id10 FROM quotation_data t0 WHERE t0.quotation_id = ? [24] '
            )

        );
    }

    public function indexForQueryManager()
    {
        return array(
            'Unit Tests' => array(
                'date' => array(
                    'engine_service' => 'file_storage_date_0',
                    'title' => 'Date'
                ),
            )
        );
    }
}