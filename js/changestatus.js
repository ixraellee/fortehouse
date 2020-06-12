
         var activate_btn = document.getElementById('activate_btn');
         var suspend_btn = document.getElementById('suspend_btn');

         activate_btn.addEventListener('click', function() {
             console.log('clicked active')
            changeStatus(1);
         })

         suspend_btn.addEventListener('click', function() {
            console.log('clicked suspend')
            changeStatus(0);
         })

         function changeStatus(action){
             var output = document.getElementById('status');
             res.textContent = 'Processing';
             var data = {
                 action: action
             }
            fetch('http://localhost/forte-master/php/change_status.php', {
            method: 'post',
            body: JSON.stringify(data)
            })
            .then(function(response) {
                return response.json();
            })
            .then(data => {
                console.log(data);
                if(data.message == 'success'){
                    //window.location.reload(true);
                }
            })
            .catch(res => console.log(res))
         }