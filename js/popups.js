function popup(title,listAction,resultTarget,ownerGroupEdit) {
  Swal.fire({
        title: title,
        showCancelButton: true,
        cancelButtonText: "Отмена",
        showLoaderOnConfirm: true,
        showClass: {
          popup: 'swal2-noanimation',
          backdrop: 'swal2-noanimation'
        },
        hideClass: {
          popup: '',
          backdrop: ''
        },
        html:
          '<select class="form-control" name="List" id="List" attribute=""></select>',
        focusConfirm: false,
        onOpen: () => {
          axios({
            method: 'post',
            url: 'fs_handler',
            data: {
                do: listAction,
            }
          })
          .then(function (response) {
            select = $("#List");
            presentList = [];
            switch(ownerGroupEdit) {
              case 'userAdd':
                presentList = currentFileACL.users;
              break;
              case 'groupAdd':
                presentList = currentFileACL.groups;
              break;
              case 'userDefaultsAdd':
                presentList = currentFileACL.defaultUsers;
              break;
              case 'groupDefaultsAdd':
                presentList = currentFileACL.defaultGroups;
              break;
            }
            // if (listAction == "listUsers") {
            //   presentList = currentFileACL.users;
            // } else {
            //   presentList = currentFileACL.groups;
            // }
            filterArr = [];
            presentList.forEach(function(item, i, arr) {
              filterArr.push(item[0]);
            });
            // console.log(presentList);
            i = 0;
              for (var key of Object.keys(response.data)) {
                if (filterArr.indexOf(response.data[key]) == -1) {
                  select.append("<option>"+response.data[key]+"</option>");
                  i++;
                }
              };
              if (!i)  select.hide();
          })
          .catch(function (error) {
            console.log(error);
          });
        },
        preConfirm: () => {//Изменяем данные в основном DOM
          $("#apply").removeClass("disabled");
          value = $("#List").val()
          if(value) {
            switch(ownerGroupEdit) {
              case 'userEdit':
                resultTarget.html(value);
                currentFileACL.owner = value
                break;
              case 'groupEdit':
                resultTarget.html(value);
                currentFileACL.group = value
                break;
              case 'userAdd':
                var user = [];
                user[0] = value;
                user[1] = {r: false, w: false, x: false};
                currentFileACL.users.push(user);
                redrawUsers();
                break;
              case 'groupAdd':
                var group = [];
                group[0] = value;
                group[1] = {r: false, w: false, x: false};
                currentFileACL.groups.push(group);
                redrawGroups();
                break;
              case 'userDefaultsAdd':
                var user = [];
                user[0] = value;
                user[1] = {r: false, w: false, x: false};
                currentFileACL.defaultUsers.push(user);
                redrawDefaultUsers();
                break;
              case 'groupDefaultsAdd':
                var group = [];
                group[0] = value;
                group[1] = {r: false, w: false, x: false};
                currentFileACL.defaultGroups.push(group);
                redrawDefaultGroups();
                break;
            }
          }
        }, //preconfirm
      });
}
  
const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

function toast(title = 'OK',type = 'success') {
  Toast.fire({
    icon: type,
    title: title
  })
}