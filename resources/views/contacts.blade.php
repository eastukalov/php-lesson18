<html lang='ru'>
<head>
    <meta charset='UTF-8'>
    <title>SELECT из нескольких таблиц</title>
    <style>
        td {padding: 5px 20px 5px 20px;border: 1px solid black;}
        thead td {text-align: center;background-color: #dbdbdb;font-weight: 700;}
        table {border-collapse: collapse;border-spacing: 0;}
        .done {margin-right: 20px;}
    </style>
</head>
<body>

@if (!empty($error))
    <p>{{  $error }}</p>
@endif

<div>
    <form method='POST' name="form">
        {{ csrf_field() }}
        <input type="hidden" name="add_edit" value="{{ $add_edit }}">
        <input type="text" name="contact_table" placeholder='Контакт' value=
             @if (!empty($contact_table))
                 "{{ $contact_table }}"
             @endif
        >
        <input type="text" name="phone_table" placeholder='Телефон' value=
            @if (!empty($phone_table))
                "{{ $phone_table }}"
            @endif
        >
        <input type='submit' value=
             @if ($add_edit=='edit')
                "Сохранить"
             @else
                "Добавить"
             @endif
        name='addedit'>
        <input type='submit' value='Найти' name='find'>
        <input type='submit' value='Сброс' name='reset'>
    </form>
</div>

<table>
    <thead>
    <tr>
        <td>Контакт</td>
        <td>Телефон</td>
        <td></td>
    </tr>
    </thead>
    <tbody>

    @foreach ($contacts as $contact)
    <tr>
        <td style="color:black;background-color:white;
                    @if (!empty($ides))
                       @foreach ($ides as $id)
                            @if ($id==$contact->id)
                                background-color:gray;
                            @endif
                        @endforeach
                    @endif
        ">{{ $contact->contact }}</td>
        <td style="color:black;background-color:white;
                    @if (!empty($ides))
                        @foreach ($ides as $id)
                            @if ($id==$contact->id)
                                background-color:gray;
                            @endif
                        @endforeach
                    @endif
                ">{{ $contact->phone }}</td>
        <td><a class="done" href="?id={{ $contact->id}}&action=edit">Изменить</a>
            <a class="done" href="?id={{ $contact->id }}&action=delete">Удалить</a>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>