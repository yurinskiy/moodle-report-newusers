# Тип вопроса "Лабораторный практикум СибГУ"

Используется для создания интерактивных практикумов с применением js.
Для того чтобы данный вопрос помечался выполненным, необходимо в тексте вопроса 
реализовать на языке JavaScript заполнение скрытого поля input класса result 
следующим значением "0533991565dbe2bd422541b1a3eb3e77a3702e16" (см. [Пример текста вопроса](#пример-текста-вопроса)).

## Установка

### Установка с использованием Git 

Для установки с помощью git выполните следующие команды из корня установленной Moodle:

    git clone https://gitlab.com/YuriyYurinskiy/lab-practicum-sibsu-question-type-moodle.git question/type/labpracticumsibsu
    echo '/question/type/labpracticumsibsu/' >> .git/info/exclude

Затем запустите процесс обновления Moodle
Администрирование > Уведомления

## Пример текста вопроса

    <button id="lab2">Solve</button>
    <script>
        $('button#lab2').click(function(e) {
            e.preventDefault();
            $(this).parentsUntil('.jsanswer').find('input.result[type=hidden]').val('0533991565dbe2bd422541b1a3eb3e77a3702e16');
        });
    </script>
