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
 * Lab Practicum (SibSU) question renderer class.
 *
 * @package    qtype
 * @subpackage labpracticumsibsu
 * @copyright  2009 The Open University
 * @copyright  2019 Yuriy Yurinskiy {@link https://yuriyyurinskiy.ru}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();


/**
 * Generates the output for Lab Practicum (SibSU) questions.
 *
 * @copyright  2009 The Open University
 * @copyright  2019 Yuriy Yurinskiy {@link https://yuriyyurinskiy.ru}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_labpracticumsibsu_renderer extends qtype_renderer
{
    /** @noinspection PhpDocMissingThrowsInspection */
    /**
     * Генерация отображения формулировки части вопроса. Это область,
     * которая содержит текст запроса и элементы управления для студентов,
     * чтобы ввести свои ответы. Некоторые типы вопросов также содержат биты
     * обратной связи, например, галочки и крестики, в этой области.
     *
     * @param question_attempt $qa попытка ответа на вопрос
     * @param question_display_options $options определяет, что должно и не должно отображаться
     * @return string фрагмент HTML
     */
    public function formulation_and_controls(question_attempt $qa,
                                             question_display_options $options)
    {
        $question = $qa->get_question();
        $currentanswer = $qa->get_last_qt_var('answer');

        $inputname = $qa->get_qt_field_name('answer');
        $inputattributes = [
                'type'  => 'hidden',
                'name'  => $inputname,
                'value' => $currentanswer,
                'id'    => $inputname,
                'size'  => 80,
                'class' => 'form-control d-inline result',
        ];

        $questiontext = $question->format_questiontext($qa);
        $input = html_writer::empty_tag('input', $inputattributes);

        $divStyle = '';
        if ($qa->get_state() != question_state::$todo && $qa->get_state() != question_state::$complete) {
            $divStyle = 'pointer-events: none; opacity: 0.4;';
        }

        $result = html_writer::tag('div', $questiontext, [
                'class' => 'qtext',
                'style' => $divStyle
        ]);

        $result .= html_writer::start_tag('div', [
                'class' => 'ablock form-inline'
        ]);
        $result .= html_writer::tag('label', html_writer::tag('span', $input, [
                'class' => 'answer'
        ]), [
                'for' => $inputattributes['id']
        ]);
        $result .= html_writer::end_tag('div');

        if ($qa->get_state() == question_state::$invalid) {
            $result .= html_writer::nonempty_tag('div', $question->get_validation_error([
                    'answer' => $currentanswer
            ]), [
                    'class' => 'validationerror'
            ]);
        }

        return $result;
    }

    /**
     * Генерирует специальный отзыв. Этот отзыв зависит от ответа ученика.
     * @param question_attempt $qa попытка ответа на вопрос
     * @return string фрагмент HTML
     */
    public function specific_feedback(question_attempt $qa)
    {
        $question = $qa->get_question();

        $answer = $question->get_matching_answer([
                'answer' => $qa->get_last_qt_var('answer')
        ]);
        if (!$answer || !$answer->feedback) {
            return '';
        }

        return $question->format_text($answer->feedback, $answer->feedbackformat,
                $qa, 'question', 'answerfeedback', $answer->id);
    }
}
