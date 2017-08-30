<?php

namespace backend\models\common;

use \yii\base\Model;

class Common extends Model{

public function transaction($sql1,$sql2){
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $ifTrue = \Yii::$app->db->createCommand($sql1)->execute();
            $ifOk = \Yii::$app->db->createCommand($sql2)->execute();
            // ... executing other SQL statements ...
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }


    }
}

