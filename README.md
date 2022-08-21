# yii2-amodule
Автор: Бабиев Алексей (alex a-t babiev d-o-t com)

Генератор модуля с объектом и вложением

1) скачиваете файл AmoduleControlle.php
2) Загружаете его в папку app\controllers\
3) В файл исправляете поля:
3.1) private $module_id = "amodule2" - id модуля, в данном случае будет создана папка app\modules\amodule2

3.2) private $module_title = "Номенклатурные категории пользователю" - название модуля

3.3) private $object_table_name = "m_test2" - название первой таблицы для основного объекта модуля

3.4) private $object_model_name = "MTest2" - название класса для основного объекта модуля

3.5) private $object_title_name = "Категория пользователю" - наименование освного объекта

3.6) private $object_list_title = "Список связок пользователь + категория" - название страницы со список основных объектов

3.7) private $object_create_title = "Добавить связку пользователь+категория" - заголовок для страницы, которая содает основной объект

3.8) private $object_name_label = "Наименование" - надпись (label) у поля name

4) Далее запускаете контроллер youwebsite.ru/amodule/index
5) action index по шагам:
5.1) скачиват шаблон из данного репозитория в папку app\modules\{значение перемнной $this->module_id}
5.2) распаковывет архив репозитория, перемещает их в папку модуля (пунт 5.1)
5.3c) делает переименования всех файлов модуля по заданные параметрам из под-пунктов 3
5.4) создает две таблицы в базе данных по заданному шаблону (одна таблица для основного объекта, другая для файлов к этому объекту)
6) вуаля... шаблон модуля для написания функционала модуля готов

Возможности модуля:
1) Читать список "основных" объектов, адрес youwebsite.ru/{}/default/index
2) Редактировать экземпляр основного объекта, адрес youwebsite.ru/{}/default/update?id=
3) Удалять экземпляр основного объекта, адрес youwebsite.ru/{}/default/delete?id= (post)
4) Просматривать экземпляр основного объекта, адрес youwebsite.ru/{}/default/view?id=
5) Загружать файлы в объект и просматривать их



