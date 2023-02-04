import express from 'express';
import * as url from 'url';
import * as path from 'path';
import {hashPassword, comparePassword} from '../schema/helper.js';
import AdminController from '../controller/AdminController.js';


const router = express.Router();
const __dirname = url.fileURLToPath(new URL('.', import.meta.url));

//================================ Middleware Section Start ===============================================
 
 // session middileware 
 router.use((req,res,next)=>{
 if(req.session.sunm==undefined || req.session.srole!="seller")
    return res.redirect("/login");    
      next();
});

var plist;
router.use("/",(req,res,next)=>{
 AdminController.fetchProfilepic({"username":req.session.sunm}).then((result)=>{
   //console.log("this is Plist :",result[0])
  plist=result;
  next();        
 }).catch((err)=>{
  console.log(err);
 });  
});

var clist;
router.use("/launchp",(req,res,next)=>{
 AdminController.fetchCategory({}).then((result)=>{
  clist=result;
  next();        
 }).catch((err)=>{
  console.log(err);
 });  
});

//middleware to fetch subcategory list
var sclist;
router.use("/launchp",(req,res,next)=>{
 AdminController.fetchSubCategory({}).then((result)=>{
     sclist=result;
  next();        
 }).catch((err)=>{
  console.log(err);
 });  
});

//following middlewares for manage products 

router.use("/editproduct/:_id",(req,res,next)=>{
 AdminController.fetchSubCategory({}).then((result)=>{
     sclist=result;
  next();        
 }).catch((err)=>{
  console.log(err);
 });  
});
router.use("/editproduct/:_id",(req,res,next)=>{
 AdminController.fetchCategory({}).then((result)=>{
  clist=result;
  next();        
 }).catch((err)=>{
  console.log(err);
 });  
});

router.use("/editproduct",(req,res,next)=>{
 AdminController.fetchCategory({}).then((result)=>{
  clist=result;
  next();        
 }).catch((err)=>{
  console.log(err);
 });  
});
router.use("/editproduct",(req,res,next)=>{
 AdminController.fetchSubCategory({}).then((result)=>{
     sclist=result;
  next();        
 }).catch((err)=>{
  console.log(err);
 });  
});




 //============= Middleware End ========================


router.get("/",(req,res)=>{
 
   res.render("sellerindex",{"plist":plist})
});


//======================Change Password Start ================================================== 
router.get("/cpseller",(req,res)=>{
 res.render("cpadmin",{"sunm":req.session.sunm,"output":"","output1":"","plist":plist});
});

router.post("/cpadmin",(req,res)=>{

var opass = req.body.opass;
      var npass =  hashPassword(req.body.npass); 
      var cnpass = npass;

      var sunm= req.session.sunm;

   AdminController.fetchUsers1({"email":sunm}).then((result)=>{
      const isValid = comparePassword(opass, result[0].password);
         if(isValid)
         {
            if(req.body.npass==req.body.cnpass)
            {
               AdminController.registerUpdateMaster({"email":sunm},{"password":cnpass}).then((result)=>{

                  res.render("cpadmin",{"sunm":req.session.sunm,"output":"Password Changed Successfully!! Login Again","output1":"","plist":plist})
               }).catch((err)=>{

                  console.log(err); 
               });
            }

            else {
               res.render("cpadmin",{"sunm":req.session.sunm,"output":"","output1":"Password Mismatched ","plist":plist})           
            }
         }

         else {
            res.render("cpadmin",{"sunm":req.session.sunm,"output":"","output1":"Incorrect Old Password!","plist":plist})
         }


   }).catch((err)=>{
      console.log(err);
   })
   
})

//=========================Change Password End====================== 

//===========================Edit Profile Start ==============================
router.get("/epseller",(req,res)=>{
            
 AdminController.fetchUsers({"email":req.session.sunm}).then((result)=>{
   
   res.render("epadmin",{"sunm":req.session.sunm,"output":"","userDetails":result,"plist":plist});   
 }).catch((err)=>{
  console.log(err);   
 });   
});

router.post("/epadmin",(req,res)=>{
      
 var userDetails=req.body; 
 var uData={"username":userDetails.username,"country":userDetails.country};
 var cData={"email":userDetails.email};
      AdminController.registerUpdateMaster(cData,uData).then((result)=>{
               console.log(result)
   res.render("epadmin",{"sunm":req.session.sunm,"output":"Profile Updated Successfully !!","userDetails":req.body,"plist":plist}); 
 
 }).catch((err)=>{
   res.render("epadmin",{"sunm":req.session.sunm,"output":" Failed to update Profile !!","userDetails":req.body,"plist":plist}); 
 
  console.log(err);    
 });   
});
//==========================Edit Profile End  ========================================


router.get("/profilepicture",(req,res)=>{

      res.render("profilepicture",{"output":"","plist":plist});

})

router.post("/profilepicture",(req,res)=>{
   var sunm = req.session.sunm;
   var picicon=req.files.picicon;
   var filename=Date.now()+"-"+picicon.name;
   var filepath=path.join(__dirname,"../public/uploads/profilepic",filename);
picicon.mv(filepath,(err)=>{
    if(err) 
      //console.log(err)  
     res.render("profilepicture",{"output":"Profile Picture uploading failed....","sunm":req.session.sunm,"plist":plist});

    else
    {
     // insert category into database
     AdminController.addProfilepic({"piciconnm":filename,"username":sunm}).then((result)=>{
        res.render("profilepicture",{"output":"picture added successfully....","sunm":req.session.sunm,"plist":plist});   
     }).catch((err)=>{
        console.log(err);   
     });    
    }
 });
});


//==============================Profile Picute End ========================== 


//=================================Product Section Start ===============================

router.get("/launchp",(req,res)=>{
 res.render("sellerlaunchp",{"sunm":req.session.sunm,"output1":"","output":"","clist":clist,"sclist":sclist,"scDetails":"","plist":""});
});
         //= using AJAX fetch product subcategory on behalf of product category
router.post("/get-subcat-by-category",(req,res)=>{
  AdminController.fetchSubCategory(req.body).then((result)=>{
      console.log(result[0].subcatnm)
   res.json({
   msg: 'success',
   states: result
});  
  }).catch((err)=>{
   console.log(err);
   res.json({
msg: 'error'
});
  });
 });

router.post("/launchp",(req,res)=>{
 var pDetails=req.body;
 var pimg=req.files.picon;
 var filename=Date.now()+"-"+pimg.name;
 var filepath=path.join(__dirname,"../public/uploads/productsImages",filename);
 pDetails={...pDetails,"pimgname":filename,"owner":req.session.sunm};
 pimg.mv(filepath,(err)=>{
    if(err)
     res.render("sellerlaunchp",{"output1":"Failed to Launch Product..!!","output":"","sunm":req.session.sunm,"output":"","clist":clist,"sclist":sclist,"scDetails":"","plist":""});      
    else
    {
     // insert tender details into database
     AdminController.addProduct(pDetails).then((result)=>{
            res.render("sellerlaunchp",{"output":"Product Added Successfully !!","output1":"","sunm":req.session.sunm,"output":"","clist":clist,"sclist":sclist,"scDetails":"","plist":""});   
     }).catch((err)=>{
        console.log(err);   
     });    
    }
 });
});
//==============================Add Product End ================================ 


//===================================Fetch Seller Products ===========================================


   router.get("/viewProducts",(req,res)=>{

   AdminController.fetchProduct({"owner":req.session.sunm}).then((result)=>{
      
      res.render("managesellerproducts",{"userDetails":result,"output":"","plist":plist})

   }).catch((err)=>{
      console.log(err);
   });

})

// Get Product by Perticular ID to edit it 
  router.get("/editproduct/:_id",(req,res)=>{
            console.log(req.params._id)
            var _id = req.params._id
 AdminController.fetchProduct({"_id":req.params._id}).then((result)=>{
  console.log(result);
   res.render("editsellerproduct",{"sunm":req.session.sunm,"output1":"","output":"","clist":clist,"sclist":sclist,"scDetails":"","pDetails":result[0],"plist":""});   
 }).catch((err)=>{
  console.log(err);   
 });   
});
// Update Product 
  router.post("/editproduct",(req,res)=>{
   
 var pDetails=req.body; 
 var uData={"catnm":pDetails.catnm,"suncatnm":pDetails.subcatnm,"description":pDetails.description,"price":pDetails.price,"pqty":pDetails.pqty};
 var cData={"title":pDetails.title};
         AdminController.productUpdateMaster(cData,uData).then((result)=>{
   res.render("editsellerproduct",{"sunm":req.session.sunm,"output1":"","output":"Product Updated Successfully !!","clist":clist,"sclist":sclist,"scDetails":"","pDetails":result,"plist":""});
 
 }).catch((err)=>{
  console.log(err);    
 });   
});

  //delete Product
router.get("/manageproductstatus/:status/:_id",(req,res)=>{
         console.log(req.params)
   AdminController.manageProductStatus(req.params).then((result)=>{

      res.redirect("/seller/viewProducts");
   }).catch((err)=>{
      console.log(err)
   })

})
export default router;




