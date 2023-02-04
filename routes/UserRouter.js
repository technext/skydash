import express from 'express';
import IndexController from '../controller/IndexController.js';
import AdminController from '../controller/AdminController.js';
import * as url from 'url';

const router = express.Router();

//=================================Middleware Section Start ========================= 
 // session middileware 
 router.use((req,res,next)=>{
   if(req.session.sunm==undefined || req.session.srole!="user")
      return res.redirect("/weblogin");    
        next();
  });
  

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
import ProductSchemaModel from '../schema/ProductSchema.js';
//=middleare to fetch cake details 
var cDetails = [];
router.use("/shopcart/:_id",(req,res,next)=>{   
          console.log(req.params)
  ProductSchemaModel.find(req.params,(err,result)=>{

    if(result)
    {
          cDetails.push(result[0]) 
          var l = cDetails.length;
          //console.log(l)
    }
    else console.log(err)   
    
})
  next();
})
//==========DELETE item from cart 

//==========DELETE item from cart 
router.use("/deleteItem/:_id",(req,res,next)=>{   
  console.log("request to delete")
    ProductSchemaModel.find(req.params,(err,result)=>{
        console.log(result[0])
    if(result)
    {  
     
     var index = cDetails.findIndex(x => x._id === result[0]._id);
      console.log(index)
      if (index >= 0) {
        cDetails.splice( index, 1 );
      }
    }
   else console.log(err)
})
  next();
})


//=============================== Middleware section end=========================


//======================================Routing Section Start ======================================

router.get("/",(req,res)=>{
 
   res.render('userindex',{"Bcakes":Bcakes,"Wcakes":Wcakes,"plist":"","output":"","cunm":cunm,"cpass":cpass,"sunm":req.session.sunm})
});




//============================Fetch Product Start ===============================   

//addtocart
router.get("/shopcart/:_id",(req,res)=>{
     
      //console.log(req.params._id)
    IndexController.fetchProducts({"_id":req.params._id}).then((result)=>{
      console.log("addedtocart")
    }).catch((err)=>{
      console.log("err");
    });

})
//delete from cart 
router.post("/deleteItem/:_id",(req,res)=>{
    IndexController.fetchProducts({"_id":req.params._id}).then((result)=>{
      res.json({
        msg: 'success',
        cakes : result
     });  
     
      console.log("deleted from cart")
    }).catch((err)=>{
      console.log("err");
    });

})


router.get("/shopcart",(req,res)=>{     
    res.render("addtocart",{"cDetails":cDetails,"sunm":req.session.sunm})
})

router.post("/cart",(req,res)=>{
    console.log(req.params)
    //console.log(req.params._id)
    IndexController.fetchProducts(req.body).then((result)=>{
       // console.log(result[0])
    //res.render("addtocart",{"cDetails":result[0]})
    }).catch((err)=>{
    console.log("err");
    });

})


//===============================Fetch  Products  End =============================

router.post("/fetchPrice",(req,res)=>{

  console.log(req.body)

  IndexController.fetchProducts(req.body).then((result)=>{
    console.log(result[0].price)
    
          res.json({
            msg: 'success',
            cake : result[0]
        })

        }).catch((err)=>{
          res.json({
            msg: 'error'
            });
        });


 });




export default router;