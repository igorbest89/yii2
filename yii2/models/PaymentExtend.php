<?php

namespace app\models;

/**
 * This is the extend model class for table "payments".
 *
 * @property integer $payment_id
 * @property integer $payment_user
 * @property integer $payment_currency
 * @property integer $payment_status
 * @property float $payment_amount
 * @property float $payment_rate
 * @property string $payment_created_at
 * @property string $payment_updated_at
 */
class PaymentExtend extends Payment
{
    //Scenarios
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    //Statuses
    const STATUS_COMPLETE = 'complete';
    const STATUS_CANCEL = 'cancel';
    const STATUS_CANCELED = 'canceled';
    const STATUS_FAIL = 'fail';
    const STATUS_PENDING = 'pending';

    /**
     * Method of getting all payments
     */
    public static function getAllPayments ()
    {
        return self::find();
    }

    /**
     * Method of change payment status
     *
     * @param $id
     * @param $status
     * @return boolean
     */
    public static function changePaymentStatus($id, $status)
    {
        $payment = self::findOne(['payment_id' => $id]);

        if ($payment) {
            $payment->scenario = self::SCENARIO_UPDATE;
            $payment->setAttribute('payment_status', $status);

            if ($payment->save()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Method of getting payment by ID
     *
     * @param $id
     * @return self
     */
    public static function getPaymentById($id)
    {
        return self::findOne(['payment_id' => $id]);
    }

    /**
     * Method of creating payment
     *
     * @param $data
     * @return string
     */
    public static function createPayment($data)
    {
//        var_dump($data); exit;
        $payment = new self;
        $payment->setScenario(self::SCENARIO_CREATE);
        $payment->payment_user = $data['payment_user'];
        $payment->payment_currency = $data['payment_currency'];
        $payment->payment_amount = $data['payment_amount'];
        $payment->payment_rate = Currency::findOne(['currency_id' => $data['payment_currency']])->currency_rate;
        $payment->payment_status = PaymentStatus::findOne(['payment_status_name' => self::STATUS_PENDING])->payment_status_id;
        $payment->payment_created_at = date("Y-m-d H:i:s", time());
        $payment->payment_updated_at = null;

        return ($payment->save(false)) ? $payment->payment_id : '';
    }

    /**
     * Method of updating payment
     *
     * @param $id
     * @param $data
     * @return string
     */
    public static function updatePayment($id, $data)
    {
//        var_dump($data); exit;
        $payment = self::findOne(['payment_id' => $id]);
        $payment->setScenario(self::SCENARIO_UPDATE);
//        $payment->load($data);
//        $payment->setAttributes([
//            'payment_user' => $data['payment_user'],
//            'payment_currency' => $data['payment_currency'],
//            'payment_amount' => $data['payment_amount'],
//            'payment_status' => $data['payment_status'],
//            'payment_rate' => Currency::findOne(['currency_id' => $data['payment_currency']])->currency_rate,
//            'payment_updated_at' => date("Y-m-d H:i:s", time())
//        ]);
        $payment->payment_user = $data['payment_user'];
        $payment->payment_currency = $data['payment_currency'];
        $payment->payment_amount = $data['payment_amount'];
        $payment->payment_status = $data['payment_status'];
        $payment->payment_rate = Currency::findOne(['currency_id' => $data['payment_currency']])->currency_rate;
        $payment->payment_updated_at = date("Y-m-d H:i:s", time());

        return ($payment->save(false)) ? $payment->payment_id : '';
    }


    /**
     * Method of deleting payment by ID
     * @param $id
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function deletePayment($id)
    {
        $payment = self::findOne(['payment_id' => $id]);

        return ($payment->delete()) ? true : false;
    }

    /**
     * Method of complete payment
     *
     * @param $id
     * @return boolean
     */
    public static function completePayment($id)
    {
        $payment = self::findOne(['payment_id' => $id]);
        $payment->setScenario(self::SCENARIO_UPDATE);
        $payment->payment_status = PaymentStatus::findOne(['payment_status_name' => self::STATUS_COMPLETE])->payment_status_id;
        $payment->payment_updated_at = date("Y-m-d H:i:s", time());

        return ($payment->save(false)) ? true : false;
    }

    /**
     * Method of cancel payment by administrator
     *
     * @param $id
     * @return boolean
     */
    public static function cancelPayment($id)
    {
        $payment = self::findOne(['payment_id' => $id]);
        $payment->setScenario(self::SCENARIO_UPDATE);
        $payment->payment_status = PaymentStatus::findOne(['payment_status_name' => self::STATUS_CANCELED])->payment_status_id;
        $payment->payment_updated_at = date("Y-m-d H:i:s", time());

        return ($payment->save(false)) ? true : false;
    }
}
