<?php
ini_set('memory_limit', '2048M');
ini_set("max_execution_time", '18000');

$_SERVER['DOCUMENT_ROOT'] = '/home/bitrix/www';
define("BX_UTF", true);
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
define("BX_BUFFER_USED", true);

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

define('ITACH_ADMIN_USER_ID', 111357);

\Bitrix\Main\Loader::includeModule('tasks');

use Bitrix\Tasks\TaskTable;

//получаем неактивных пользователей, привязанных к подразделению
$arOfInactiveUsers = [];
$result = \Bitrix\Main\UserTable::getList(array(
    'filter' => [
        '=ACTIVE' => 'N',
        '!LOGIN' => false
//        '!UF_DEPARTMENT' => false
    ],
    'select' => ['ID'],
));

while ($arUser = $result->fetch()) {
    $arOfInactiveUsers[] = $arUser['ID'];
}
//Завершаем задачи неактивных пользователей, привязанные к лиду или сделке
if (!empty($arOfInactiveUsers)) {


    foreach (getList($arOfInactiveUsers) as $task) {
        foreach ($task['UF_CRM_TASK'] as $linkedCRMEntity) {
            //проверим что задача привязана к лиду или сделке
            if (str_contains($linkedCRMEntity, 'D_') || str_contains($linkedCRMEntity, 'L_')) {
                //завершаем задачу
                $taskobj = new TaskTable();
                $res = $taskobj->update($task['ID'], ['STATUS' => CTasks::STATE_COMPLETED]);
                if ($res->isSuccess()) {
                    $resultMessage = 'Завершена задача ' . $task['ID'];
                    file_put_contents(__DIR__ . '/closeTasksOfInactiveUsers.log', print_r($task['ID'], 1) . PHP_EOL, FILE_APPEND);
                }
            }
        }
    }
}
function getList($arOfInactiveUsers)
{
    $task = new TaskTable();

    $filter = [
        '!STATUS' => CTasks::STATE_COMPLETED,
        'RESPONSIBLE_ID' => $arOfInactiveUsers,
        '!UF_CRM_TASK' => false
    ];
    $select = ['*', 'UF_CRM_TASK'];
    $dbResult = $task::GetList(
        [
            'select' => $select,
            'filter' => $filter,
        ]
    );

    while ($task = $dbResult->Fetch()) {
        yield $task;
    }
}