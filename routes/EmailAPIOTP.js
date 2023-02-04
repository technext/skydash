import nodemailer from 'nodemailer';
var sendMailOTP=(email,otp)=>{
   process.env.NODE_TLS_REJECT_UNAUTHORIZED='0'

var transporter = nodemailer.createTransport({
  service: 'gmail',
  auth: {
    user: 'vasubirla@gmail.com',
    pass: 'mtvrqzmxlarnrgzh'
  }
});

var mailOptions = {
  from: 'vasubirla@gmail.com',
  to: email,
  subject: 'Verification Mail MyApp',
  html: "<h3>Your OTP to reset password is :</h1>"+"<h3>"+otp+"</h1>"

}

transporter.sendMail(mailOptions, function(error, info){
  if (error) {
    console.log(error);
  } else {
    console.log('Email sent: ' + info.response);
  }
}); 

}


export default sendMailOTP;