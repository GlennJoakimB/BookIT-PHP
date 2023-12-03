<?php

namespace app\models
{
    use app\core\Application;
    use app\core\db\DbModel;

    /**
     * Booking short summary.
     *
     * Booking description.
     *
     * @version 1.0
     * @author Trivinyx <tom.a.s.myre@gmail.com>
     * @package app\models
     */
    class Booking extends DbModel
    {
        const STATUS_DELETED = 0;
        const STATUS_AVAILABLE = 1;
        const STATUS_UNAVAILABLE = 2;

        public ?int $id = 0;
        public string $group_id = '';
        public int $course_id = 0;
        public string $course_name = '';
        public string $subject = '';
        public int $holder_id = 0;
        public ?User $holder = null;
        public string $date = '';
        public string $start_time = '';
        public string $end_time = '';
        public ?int $booker_id = null;
        public ?User $booker = null;
        public ?string $booker_note = '';
        public int $status = 0;
        public string $last_updated = '';

        //for determining the button pressed
        public string $submit = '';


        public static function tableName(): string
        {
            return 'bookings';
        }

        public static function primaryKey(): string
        {
            return 'id';
        }

        public static function attributes(): array
        {
            //array of attributes, excluding the primary key, last_updated.
            return ['course_id', 'subject', 'holder_id', 'start_time', 'end_time', 'booker_id', 'booker_note', 'status'];
        }

        public function rules(): array
        {
            return [
                'course_id' => [self::RULE_REQUIRED],
                'subject' => [self::RULE_REQUIRED],
                'date' => [self::RULE_REQUIRED],
                'start_time' => [self::RULE_REQUIRED],
                'end_time' => [self::RULE_REQUIRED]
            ];
        }

        public function labels(): array
        {
            return [
                'course_id' => 'Course',
                'subject' => 'Subject',
                'date' => 'Date',
                'start_time' => 'Start time',
                'end_time' => 'End time',
                'booker_note' => 'Booking notes'
            ];
        }

        //finds holder from db
        public function getHolder()
        {
            //return User::findOne(['id' => $this->holder_id]) and set local holder;
            $this->holder = User::findOne(['id' => $this->holder_id]);
            return $this->holder;
        }

        //find booker from db
        public function getBooker()
        {
            //return User::findOne(['id' => $this->booker_id]) and set local booker;
            $this->booker = User::findOne(['id' => $this->booker_id]);
            return $this->booker;
        }

        public function save()
        {
            //format variables
            $this->start_time = $this->date . 'T' . $this->start_time;


            //tell DbModel to save
            //return parent::save();
        }


        public function create() {
            //format variables
            $this->holder_id = Application::$app->user->id;
            $this->status = self::STATUS_AVAILABLE;


            //tell DbModel to save
            //return parent::save();
        }
    }
}