    //transfer form
    var form = document.getElementById('transfer-form');
    
    var transferBtn = document.getElementById('transfer-btn')
    
    // transferBtn.addEventListener('click',function(){
    //     var amount = document.getElementById('amount').value;
    // var bank_name = document.getElementById('bank_name').value;
    // var bank_address = document.getElementById('bank_address').value;
    // var country = document.getElementById('country').value;
    // var account_name = document.getElementById('account_name').value;
    // var account_number = document.getElementById('account_number').value;
    // var details = document.getElementById('transfer_details').value;
    // var transfer_type = document.getElementById('transfer_type').value;
    // var short_code = document.getElementById('short_code').value;
    // var result = document.getElementById('result');
    // var allInputs = [amount,bank_name,bank_address,country,account_name,account_number,details,transfer_type,short_code]
    
    //     var check = allInputs.some((val)=> val === '')
    //     if(!check){
    //     }else{
    //         alert('all fields must be filled');
    //     }
    // })
    
    //otp form 
    var otpForm = document.getElementById('otp-form');
    var otpBtn = document.getElementById('verify-otp-button');

    
    
    otpBtn.addEventListener('click',function (event){
        var otp = document.getElementById('otp').value;
        var result = document.getElementById('result');
        event.preventDefault();
        result.textContent = 'verifying Two-Way Authentication Security Code';
        console.log('clicked',otp)
        data = {
            otp
        }
        //send post request
        fetch('http://localhost/forte-master/php/verify_otp.php', {
            method: 'post',
            body: JSON.stringify(data)
        })
        .then(function(response) {
            return response.json();
        })
        .then(data => {
            console.log(data)
            if(data.message == 'success'){
                result.textContent = 'Two-Way Authentication Security Code has been verified, processing transfer ...';
                setTimeout(()=>{
                    document.getElementById('hidden_submit').click()
                    //form.submit();
                },1000)
            }else{
                result.textContent = 'incorrect Two-Way Authentication Security Code';
            }
        })
    });
