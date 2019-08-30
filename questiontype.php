<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Question type class for the Lab Practicum (SibSU) question type.
 *
 * @package    qtype
 * @subpackage labpracticumsibsu
 * @copyright  2019 Yuriy Yurinskiy {@link https://yuriyyurinskiy.ru}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/questionlib.php');
require_once($CFG->dirroot . '/question/engine/lib.php');
require_once($CFG->dirroot . '/question/type/labpracticumsibsu/question.php');


/**
 * The Lab Practicum (SibSU) question type.
 *
 * @copyright  2019 Yuriy Yurinskiy {@link https://yuriyyurinskiy.ru}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_labpracticumsibsu extends question_type
{
    /**
     * Если ваш тип вопроса имеет таблицу, которая расширяет таблицу вопросов,
     * и вы хотите, чтобы базовый класс автоматически сохранял, создавал
     * резервные копии и восстанавливал дополнительные поля, переопределите
     * этот метод, чтобы вернуть массив, в котором первый элемент является
     * именем таблицы, и последующие записи являются именами столбцов (кроме id и questionid).
     * @return mixed array как указано выше, или null, чтобы сказать базовому классу ничего не делать.
     */
    public function extra_question_fields()
    {
        return null;
    }
}
