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
 * Lab Practicum (SibSU) question definition class.
 *
 * @package    qtype
 * @subpackage labpracticumsibsu
 * @copyright  2009 The Open University
 * @copyright  2019 Yuriy Yurinskiy {@link https://yuriyyurinskiy.ru}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/question/type/questionbase.php');

/**
 * Represents a Lab Practicum (SibSU) question.
 *
 * @copyright  2009 The Open University
 * @copyright  2019 Yuriy Yurinskiy {@link https://yuriyyurinskiy.ru}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_labpracticumsibsu_question extends question_graded_by_strategy
        implements question_response_answer_comparer
{
    public function __construct()
    {
        parent::__construct(new question_first_matching_answer_grading_strategy($this));
    }

    public function get_expected_data()
    {
        return [
                'answer' => PARAM_RAW_TRIMMED
        ];
    }

    /**
     * Создайте текстовое резюме ответа.
     * @param array $response - ответ, который можно передать в {@link grade_response()}.
     * @return string - текстовое резюме этого ответа, которое можно использовать в отчетах.
     */
    public function summarise_response(array $response)
    {
        if (isset($response['answer'])) {
            return $response['answer'];
        } else {
            return null;
        }
    }

    /**
     * Используется многими способами поведения, чтобы определить,
     * является ли ответ ученика на вопрос завершенным. То есть,
     * должна ли попытка вопроса перейти в состояние ЗАВЕРШЕНО или НЕПОЛНО.
     *
     * @param array $response ответы, возвращаемые
     *      {@link question_attempt_step::get_qt_data()}.
     * @return bool является ли этот ответ полным ответом на этот вопрос.
     */
    public function is_complete_response(array $response)
    {
        return array_key_exists('answer', $response) &&
                ($response['answer'] || $response['answer'] === '0');
    }

    /**
     * Используйте многие из вариантов поведения, чтобы определить,
     * предоставил ли студент достаточно ответа для автоматической оценки вопроса
     * или его следует считать отмененным.
     *
     * @param array $response ответы, возвращаемые
     *      {@link question_attempt_step::get_qt_data()}.
     * @return bool может ли этот ответ быть оценен.
     */
    public function is_gradable_response(array $response)
    {
        return $this->is_complete_response($response);
    }

    /** @noinspection PhpDocMissingThrowsInspection */
    /**
     * В ситуациях, когда is_gradable_response ) возвращает false,
     * этот метод должен генерировать описание проблемы.
     * @param array $response
     * @return string сообщение.
     */
    public function get_validation_error(array $response)
    {
        if ($this->is_gradable_response($response)) {
            return '';
        }

        return get_string('pleaseenterananswer', 'qtype_labpracticumsibsu');
    }

    /**
     * Используйте многие из поведений, чтобы определить, изменился ли ответ учащегося.
     * Обычно это используется для определения того, что новый набор ответов можно безопасно отбросить.
     *
     * @param array $prevResponse ранее записанные ответы на этот вопрос,
     *      возвращенные {@link question_attempt_step::get_qt_data()}
     * @param array $newResponse новые ответы, в том же формате.
     * @return bool одинаковы ли два набора ответов - то есть
     *      можно ли безопасно отбрасывать новый набор ответов.
     */
    public function is_same_response(array $prevResponse, array $newResponse)
    {
        return question_utils::arrays_same_at_key_missing_is_blank(
                $prevResponse, $newResponse, 'answer');
    }

    /** @return array of {@link question_answers}. */
    public function get_answers()
    {
        // Возвращает массив правильных ответов
        return [
                new question_answer(1, "f899139df5e1059396431415e770c6dd", 1, "", 1), // 100
                new question_answer(2, "812b4ba287f5ee0bc9d43bbf5bbe87fb", 0.95, "", 1), // 95
                new question_answer(3, "8613985ec49eb8f757ae6439e879bb2a", 0.9, "", 1), // 90
                new question_answer(4, "3ef815416f775098fe977004015c6193", 0.85, "", 1), // 85
                new question_answer(5, "f033ab37c30201f73f142449d037028d", 0.8, "", 1), // 80
                new question_answer(6, "d09bf41544a3365a46c9077ebb5e35c3", 0.75, "", 1), // 75
                new question_answer(7, "7cbbc409ec990f19c78c75bd1e06f215", 0.7, "", 1), // 70
                new question_answer(8, "fc490ca45c00b1249bbe3554a4fdf6fb", 0.65, "", 1), // 65
                new question_answer(9, "072b030ba126b2f4b2374f342be9ed44", 0.6, "", 1), // 60
                new question_answer(10, "b53b3a3d6ab90ce0268229151c9bde11", 0.55, "", 1), // 55
                new question_answer(11, "c0c7c76d30bd3dcaefc96f40275bdc0a", 0.5, "", 1), // 50
                new question_answer(12, "6c8349cc7260ae62e3b1396831a8398f", 0.45, "", 1), // 45
                new question_answer(13, "d645920e395fedad7bbbed0eca3fe2e0", 0.4, "", 1), // 40
                new question_answer(14, "1c383cd30b7c298ab50293adfecb7b18", 0.35, "", 1), // 35
                new question_answer(15, "34173cb38f07f89ddbebc2ac9128303f", 0.3, "", 1), // 30
                new question_answer(16, "8e296a067a37563370ded05f5a3bf3ec", 0.25, "", 1), // 25
                new question_answer(17, "98f13708210194c475687be6106a3b84", 0.2, "", 1), // 20
                new question_answer(18, "9bf31c7ff062936a96d3c8bd1f8f2ff3", 0.15, "", 1), // 15
                new question_answer(19, "d3d9446802a44259755d38e6d163e820", 0.1, "", 1), // 10
                new question_answer(20, "e4da3b7fbbce2345d7772b0674a318d5", 0.05, "", 1), // 5
        ];
    }

    /**
     * @param array $response the response.
     * @param question_answer $answer an answer.
     * @return bool whether the response matches the answer.
     */
    public function compare_response_with_answer(array $response, question_answer $answer)
    {
        // Возвращаем false, если не введен ответ
        if (!array_key_exists('answer', $response) || is_null($response['answer'])) {
            return false;
        }

        return question_utils::arrays_same_at_key_missing_is_blank(
                $response, (array)$answer, 'answer');
    }
}
