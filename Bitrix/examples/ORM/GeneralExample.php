<?php
namespace Itachsoft\Loyalitysystem;

use Bitrix\Main\Entity;
use Bitrix\Main\ORM\Query\Join;

class BonusRulesTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'itachsoft_loyalitysystem_bonus_rules';
    }

    public static function getMap()
    {
        return [
            new Entity\IntegerField('ID', [
                'primary' => true,
                'autocomplete' => true
            ]),
            new Entity\StringField('TITLE', [
                'required' => true
            ]),
            new Entity\BooleanField('ACTIVE', [
                'required' => true,
                'values' => ['N', 'Y']
            ]),
            new Entity\DatetimeField('ACTIVE_FROM', [
                'required' => true
            ]),
            new Entity\DatetimeField('ACTIVE_TO', [
                'required' => true
            ]),
            new Entity\IntegerField('CREATED_BY', [
                'required' => true
            ]),
            new Entity\StringField('PERIOD', [
                'validation' => function () {
                    return [
                        new Entity\Validator\Length(null, 255),
                        function ($value, $primary, $row, $field) {
                            $validValues = ['YEAR', 'MONTH', 'WEEK'];
                            if (!in_array($value, $validValues)) {
                                return 'Недопустимое значение для поля PERIOD. Допустимые значения: YEAR, MONTH, WEEK.';
                            }
                            return true;
                        }
                    ];
                }
            ]),
            new Entity\IntegerField('QUANTITY', [
                'required' => true
            ]),
            new Entity\TextField('CONDITIONS', []),
            new Entity\StringField('TYPE', []),
            new Entity\StringField('ACTION', []),
            new Entity\ReferenceField(
                'USER',
                \Bitrix\Main\UserTable::class,
                Join::on('this.CREATED_BY', 'ref.ID')
            )
        ];
    }
}