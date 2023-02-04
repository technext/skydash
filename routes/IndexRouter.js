import express from 'express';
import IndexController from '../controller/IndexController.js';
import AdminController from '../controller/AdminController.js';
import IndexModel from '../models/IndexModel.js';
import './FBpassport.js';
import passport from 'passport';
import {hashPassword, comparePassword} from '../schema/helper.js';
import sendMailOTP from './EmailAPIOTP.js';
import { MongoClient } from 'mongodb';
import axios from 'axios';
//import UserController from '../controller/UserController.js'
//import AdminController from '../controller/UserController.js';

import * as url from 'url';
const router = express.Router();
//=============================== Middleware Section Start ========================================= 

//middle ware to get product details in a variable 
var plist;
router.use("/",(req,res,next)=>{
 AdminController.fetchProfilepic({}).then((result)=>{
  plist=result;
  next();        
 }).catch((err)=>{
  console.log(err);
 });  
});

//middleware to manage user details in cookies
var cunm,cpass;
cunm="";
cpass="";
router.use("/",(req,res,next)=>{
 if(req.cookies.cunm!=undefined)
 {
  cunm=req.cookies.cunm;
  cpass=req.cookies.cpass;
 }
 next();
});
router.use("/login",(req,res,next)=>{
 if(req.cookies.cunm!=undefined)
 {
  cunm=req.cookies.cunm;
  cpass=req.cookies.cpass;
 }
 next();
});
var otp;
function setValue()
      {
    otp =   Math.random();
      otp = otp * 1000000;
        otp = parseInt(otp);
          console.log(otp);
        }

function getValue()
{
    console.log(otp); // yup, it's "test"

}

//Middleware to get cake list to send on menu.ejs
var Bcakes;
router.use("/menu",(req,res,next)=>{
    IndexController.fetchProducts({"catnm":"birthday cake"}).then((result)=>{
    Bcakes = result;
      next();
  }).catch((err)=>{
    console.log(err);
  });

})

router.use("/",(req,res,next)=>{
  IndexController.fetchProducts({"catnm":"birthday cake"}).then((result)=>{
  Bcakes = result;
    next();
}).catch((err)=>{
  console.log(err);
});

})

var Wcakes;
router.use("/menu",(req,res,next)=>{
    IndexController.fetchProducts({"catnm":"wedding cakes"}).then((result)=>{
    Wcakes = result;
      next();
  }).catch((err)=>{
    console.log(err);
  });

})

router.use("/",(req,res,next)=>{
  IndexController.fetchProducts({"catnm":"wedding cakes"}).then((result)=>{
  Wcakes = result;
    next();
}).catch((err)=>{
  console.log(err);
});

})

//================================Middleware Section End =============================================

//=====================Routing Start ======================= 
router.get("/",(req,res)=>{

   res.render('webindex',{"Bcakes":Bcakes,"Wcakes":Wcakes,"plist":plist,"output":"","cunm":cunm,"cpass":cpass,"sunm":req.session.sunm})
})
router.get('/about',(req,res)=>{
    res.render('about',{"sunm":req.session.sunm})
})

router.get('/menu',(req,res)=>{
    res.render('menu',{"Bcakes":Bcakes,"Wcakes":Wcakes,"sunm":req.session.sunm})
})

router.get('/team',(req,res)=>{
    res.render('team',{"sunm":req.session.sunm})
})

router.get('/service',(req,res)=>{
    res.render('service',{"sunm":req.session.sunm})
})
router.get('/testimonial',(req,res)=>{
    res.render('testimonial',{"sunm":req.session.sunm})
})
router.get('/contact',(req,res)=>{
    res.render('contact',{"sunm":req.session.sunm})
})
router.get('/orderconfirmed',(req,res)=>{
    res.render('orderplaced',{"sunm":req.session.sunm})
})

//====================== Register Admin/Seller ====================================
    router.get("/register",(req,res)=>{
     res.render("register",{"output":""});
    });

    

    router.post("/register",(req,res)=>{
      
     IndexController.registerUser(req.body).then((result)=>{
        res.render("register",{"output":"User register successfully..."});

     }).catch((err)=>{
        res.render("register",{"output":err});
     });
    });

    router.get("/sellerregister",(req,res)=>{
     res.render("sellerregister",{"output":"","plist":""});
    });


    router.post("/sellerregister",(req,res)=>{
            IndexController.registerSeller(req.body).then((result)=>{
        res.render("sellerregister",{"output":"User register successfully..."});
     }).catch((err)=>{
        res.render("sellerregister",{"output":err});
     });
    });



//========================== Register Admin/Seller End==================================

//=============================Register User/Customer Start =================================== 
router.get("/webregister",(req,res)=>{
  res.render("webregister",{"output":""});
 });

//============================Register User/Customer End=========================================

//============================== Login Admin/seller End========================================
      router.get("/login",(req,res)=>{
        if(req.session.sunm != undefined)
        {
            req.session.sunm = undefined
          }
       res.render("login",{"output":"","cunm":cunm,"cpass":cpass});
      });


router.post("/login",(req,res)=>{
 var userDetails={"email":req.body.email,"password":req.body.password};   
 IndexController.userLogin(userDetails).then((result)=>{

    //to store user details in cookie on remember
    if(req.body.chk!=undefined)
    {
     res.cookie("cunm",req.body.email,{"maxAge":3600000});
     res.cookie("cpass",req.body.password,{"maxAge":3600000});        
    }
    //console.log(result.userDetails)
 if(result.s==1 || result.s==2 || result.s ==3 )
    {
     req.session.sunm=result.userDetails.email;req.session.srole=result.userDetails.role;
    } 
   // (result.s==0)?res.send("Invalid password or Verify Your Account once"):(result.s==1)?res.send("/admin- Logged in Successfully"):res.send("Logged in Successfully")
   (result.s==0)?res.render("login",{"output":"Invalid password or Verify Your Account once","cunm":cunm,"cpass":cpass}):((result.s==1)?res.redirect("/admin"):(result.s==2)?res.redirect("/seller"):res.redirect("/user"));             
    
 }).catch((err)=>{
    res.render("login",{"output":err,"cunm":cunm,"cpass":cpass});
 });
});

//====================================== Login Admin/Seller End ============================================ 

//=========================Login Customer/User  Start ===================================================== 

router.get("/weblogin",(req,res)=>{
  if(req.session.sunm != undefined)
  {
      req.session.sunm = undefined
    }
 res.render("weblogin",{"output":"","cunm":cunm,"cpass":cpass,"sunm":req.session.sunm});
});

//=======================Login Customer End ===================================




//=================================Login With Facebook Start======================================== 

router.get("/auth/facebook", passport.authenticate("facebook"));

router.get("/auth/facebook/callback",
  passport.authenticate("facebook", {
    successRedirect: "/pass",
    failureRedirect: "/fail"
  })
);

router.get("/pass", (req, res) => {
   const obj = JSON.parse(JSON.stringify(req.session.passport.user))

    console.log(obj)    
   
   if(!req.session)
    res.redirect('/fail');

     // req.session.sunm=obj.id;
      IndexController.registerFacebookUser(obj).then((result)=>{
           if(result)
           {
            req.session.sunm=obj.id; req.session.srole=result.role;  // this is for session - will be used in future
           }         

           res.redirect("/user")
       
      }).catch((err)=>{
          res.render("login",{"output":"Unable to Login With facebook!!"})
          console.log(err)
      })

});


router.get("/fail", (req, res) => {
  res.render("login",{"output":"facebook Authentication Failed !!"})
});

router.get("/privacy/policy/",(req,res)=>{

  res.render("privacy")

})

//======================================Loging with Facebook End=====================================

//================================Forget Password Start =============================================== 


router.get("/resetpasswordOTP",(req,res)=>{
            
    res.render("resetpasswordOTP",{"output":"","plist":""});
})


router.post("/forgotpassword",(req,res)=>{

    
    AdminController.fetchUsers({"email":req.body.email}).then((result)=>{
             if(result==null)
       {
          //res.json("Account Does not exist")
          res.render("resetpasswordOTP",{"output":"Account doesn't exist","sunm":req.body.email,"plist":""});
       }
   
    else 
    {
      setValue();
    sendMailOTP(req.body.email,otp);
       // res.json("Otp Sent to Your Email")
      res.render("forgotpassword",{"output":"OTP sent to Your Email, Enter below","sunm":req.body.email,"plist":""}); 
    }
     
    }).catch((err)=>{
      res.render("resetpasswordOTP",{"output":"problem in OTP Sending","sunm":req.body.email,"plist":""});

    })
   
})



router.post('/resetpassword',function(req,res){
  
 if(req.body.otp==otp)
   {
     
     if(req.body.npass == req.body.cnpass)
     {
       MongoClient.connect("mongodb://localhost:27017/AdminSecurity",(err,db)=>{
   var userDetails = req.body;

    if (err) throw err;
    var dbo = db.db("AdminSecurity");    
    //const id = {_id: userDetails._id}; // selector(id)must be in JS object
    const email={email: userDetails.email};

      req.body.cnpass = hashPassword(req.body.cnpass);
     const query = {$set: {password: req.body.cnpass }};


    dbo.collection("register").updateOne(email,query,(err,result) =>{
         console.log(result)
      if (err){
         res.render("forgotpassword",{"output":"Failed reset","plist":"","cunm":cunm,"cpass":cpass,"sunm":req.body.email});
      }else{

        res.render("login",{"output":"password reset successfully","plist":"","cunm":cunm,"cpass":cpass,"sunm":req.body.email});
        //res.send(result);

      }
      db.close();

    });

  });
     }
     else 
      {
          res.render("forgotpassword",{"output":"password mismatch!","sunm":req.body.email,"plist":""});
      }

   }
   else
   {
      res.render("forgotpassword",{"output":"Wrong OTP","sunm":req.body.email,"plist":""});
       
   }

}); 

//============================= Forget Password End ================================ 


export default router;