
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
             var res = document.getElementById('status');
             res.value = 'Processing...';
             const urlParams = new URLSearchParams(window.location.search);
            const id = urlParams.get('id');
           
            if (!id) {
                alert('invalid details');
            }
             var data = {
                 action,id
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
                    res.value = data['verbal_status'];
                    // document.getElementById('form').submit();
                }
            })
            .catch(res => console.log(res))
         }