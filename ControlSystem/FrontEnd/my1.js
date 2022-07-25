
function loadData() {

    $.get('http://localhost/controlsystem/users', (resp, status) => {
        const data = JSON.parse(resp)
        const users = data.users
        sessionStorage.setItem("users",JSON.stringify(users));
        const roleToSlug = {1: "Admin", 0: "User"}
        $("#users-list").empty();
        users.forEach(user => {
            $("#users-list").append(`<tr data-id="${user.id}">
                    <td class="align-middle">
                      <div
                        class="custom-control custom-control-inline custom-checkbox custom-control-nameless m-0 align-top">
                        <input type="checkbox" class="custom-control-input item-checkbox" id="${user.id}">
                        <label class="custom-control-label" for="${user.id}"></label>
                      </div>
                    </td>
                    <td class="text-nowrap align-middle">${user.FirstName} ${user.LastName}</td>
                    <td class="text-nowrap align-middle"><span>${roleToSlug[user.Role]}</span></td>
                    <td class="text-center align-middle"><i class="fa fa-circle ${user.Status ? "active-circle": "not-active-circle"} "></i></td>
                    <td class="text-center align-middle">
                      <div class="btn-group align-top">
                        <button class="btn btn-sm btn-outline-secondary badge user-edit" type="button" data-toggle="modal"
                          data-target="#user-form-modal">Edit</button>
                        <button class="btn btn-sm btn-outline-secondary badge" type="button"><i
                            class="fa fa-trash" data-toggle="modal"
                          data-target="#mi-modal" ></i></button>
                      </div>
                    </td>
                  </tr>`)

        })

        addHandlers()
    })

}

$(document).ready(() => {
    loadData();

    let buttons = $('#top-buttons').html()
    $('#bottom-buttons').append(buttons)
    $('.all').change(function () {
        $('.all').val($(this).val())
    })

    $('.btn_ok').click(function() {
        const setterVal = $('.all').val()
        console.log(setterVal)
        let arr=[]
        $('input:checkbox.item-checkbox').each(function () {

            if (this.checked) {
                const userId = $(this).closest('tr').data('id')
                arr.push(userId)
            }

        });
        if ($('.all').val() == 0 && arr.length!==0) {
            $('#message-error').empty();
            $('#message-error').append("Выберите действие!");
            $('#modal-error').modal('show');
        }
        else if ($('.all').val() != 0 && arr.length==0) {
            $('#message-error').empty();
            $('#message-error').append("Выберите пользователей!");
            $('#modal-error').modal('show');
        }
        else {
            if (parseInt(setterVal) === 3) {
                $.each(arr, function (index, value) {
                    $.get('http://localhost/controlsystem/removeUser', {'id': value}, function (resp, status) {
                        $("tr[data-id='" + value + "']").remove()
                    })
                })
            }

            if (parseInt(setterVal) === 2 || parseInt(setterVal) === 1) {
                $.post('http://localhost/controlsystem/setstatus', {'id': arr, 'status': parseInt(setterVal) === 1 ? 1 : 0}, function (resp, status) {
                    loadData()
                })
            }
        }
    })
    $('#modal-btn-ok').click(function (){
        $('#modal-error').modal('hide')
    })

    $('#userSave').click(function (){
        const userId = $('#editUser').val()
        if (userId) {
            $.post('http://localhost/controlsystem/updateUser', {
                    'id': userId,
                    'FirstName': $('#first-name').val(),
                    'LastName': $('#last-name').val(),
                    'Role': $('#role').val(),
                    'Status': $('#flexSwitchCheckDefault').prop('checked')? 1 : 0
                }, function (resp, status) {
                    const respData = JSON.parse(resp)
                    if (respData.status == false) {
                        alert(respData.error.message)
                    } else {
                        loadData();
                    }
                }
            )}
        else {
            $.post('http://localhost/controlsystem/addUser', {
                'FirstName': $('#first-name').val(),
                'LastName': $('#last-name').val(),
                'Role': parseInt($('#role').val()),
                'Status': $('#flexSwitchCheckDefault').prop('checked')? true : false
            }, function (resp, status) {
                const respData = JSON.parse(resp)
                if (respData.status == false) {
                    alert(respData.error.message)
                } else {
                    loadData();
                }

            })
        }
    })

    $('#addUser').click(() => {
        $('#UserModalLabel').empty()
        $('#UserModalLabel').append("Add User")
        $('#editUser').val('')
        $('#first-name').val('')
        $('#last-name').val('')
        $('#role').val(0)
        $('#flexSwitchCheckDefault').prop('checked', false)
    })

    $('#modal-btn-yes').click(function () {
        const userId = $('#currentUser').val()
        $.get('http://localhost/controlsystem/removeUser', {'id': userId}, function (resp, status) {
            $("tr[data-id='" + userId + "']").remove()


        })
    })

    $('#all-items').click(() => {
        $("input:checkbox").prop("checked", $('#all-items').prop("checked"))
    })
})
function addHandlers(){

    $('.item-checkbox').click(function() {
        if ($('#all-items').prop("checked") == true && $(this).prop('checked') == false) {
            $('#all-items').prop("checked", false)
        }
    })
    $('.fa-trash').click(function() {
        const item = $(this).closest('tr')
        const userId = item.data('id')
        $('#currentUser').val(userId)

    })



    $('.user-edit').click(function (){
        $('#UserModalLabel').empty()
        $('#UserModalLabel').append("Edit User")
        const usersData = sessionStorage.getItem("users");
        const users =  JSON.parse(usersData)
        const item = $(this).closest('tr')
        const userId = item.data('id')
        const currentUser =  users.find(user => user.id == userId)
        console.log(currentUser)
        $('#first-name').val(currentUser.FirstName)
        $('#last-name').val(currentUser.LastName)
        $('#role').val(currentUser.Role)
        $('#flexSwitchCheckDefault').prop('checked', Boolean(currentUser.Status))
        $('#editUser').val(currentUser.id)
    })
}