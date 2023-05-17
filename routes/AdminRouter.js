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
 if(req.session.sunm==undefined || req.session.srole!="admin")
    return res.redirect("/login");    
      next();
});


//middleware to fetch category list
var clist;
router.use("/addsubcategory",(req,res,next)=>{
 AdminController.fetchCategory({}).then((result)=>{
  clist=result;
  next();        
 }).catch((err)=>{
  console.log(err);
 });  
});


//middleware to get category list 
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

//middleware to count number of users
var count;
router.use("/",(req,res,next)=>{
AdminController.fetchUsers1({}).then((result)=>{
      var l = result.length;
      //var nava = result[l-1]
      count=result[l-1]
      next();
   }).catch((err)=>{
      console.log(err);
   });

})


//==============================Middleware Section End==================================

//=========================== Routing ==================================================================
router.get("/",(req,res)=>{

   res.render("adminindex",{"sunm":req.session.sunm,"srole":req.session.srole,"plist":plist,"count":count})
 
   //res.send("<h1> Admin Security Panel</h1>")
});

//==========Admin Change Password Start =================== 



router.get("/cpadmin",(req,res)=>{
 res.render("cpadmin",{"sunm":req.session.sunm,"output":"","output1":"","plist":"","count":count});
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

                  res.render("cpadmin",{"sunm":req.session.sunm,"output":"Password Changed Successfully!! Login Again","output1":"","plist":"","count":count})
               }).catch((err)=>{

                  console.log(err); 
               });
            }

            else {
               res.render("cpadmin",{"sunm":req.session.sunm,"output":"","output1":"Password Mismatched ","plist":"","count":count})           
            }
         }

         else {
            res.render("cpadmin",{"sunm":req.session.sunm,"output":"","output1":"Incorrect Old Password!","plist":"","count":count})
         }


   }).catch((err)=>{
      console.log(err);
   })
   
})

//==============End Change Password=============

//=================================User/Seller Management Start ==================

router.get("/manageusers",(req,res)=>{

   AdminController.fetchUsers1({"role":"user"}).then((result)=>{
      res.render("manageusers",{"output":"","userDetails":result,"plist":"","count":count})
   }).catch((err)=>{
      console.log(err);
   });

})

router.get("/managesellers",(req,res)=>{

   AdminController.fetchUsers1({"role":"seller"}).then((result)=>{
      res.render("managesellers",{"output":"","userDetails":result,"plist":"","count":count})
   }).catch((err)=>{
      console.log(err);
   });

})



router.get("/manageuserstatus/:status/:_id",(req,res)=>{

   AdminController.manageUserStatus(req.params).then((result)=>{

      res.redirect("/admin/manageusers");
   }).catch((err)=>{
      console.log(err)
   })

})
router.get("/managesellerstatus/:status/:_id",(req,res)=>{

   AdminController.manageUserStatus(req.params).then((result)=>{

      res.redirect("/admin/managesellers");
   }).catch((err)=>{
      console.log(err)
   })

})




//=================================User Management End========================

//===========================Add Product Category============================== 
router.get("/addcategory",(req,res)=>{
 res.render("addcategory",{"output":"","sunm":req.session.sunm,"plist":"","count":count});
});


router.post("/addcategory",(req,res)=>{
 //console.log(req.body);   
 //console.log(req.files);
 
 var catnm=req.body.catnm;
 var caticon=req.files.caticon;
 var filename=Date.now()+"-"+caticon.name;
 //console.log(catnm+"-------"+filename);
 var filepath=path.join(__dirname,"../public/uploads/categoryicons",filename);
 caticon.mv(filepath,(err)=>{
    if(err) 
      //console.log(err)  
     res.render("addcategory",{"output":"Category uploading failed....","sunm":req.session.sunm,"plist":"","count":count});

    else
    {
     // insert category into database
     AdminController.addCategory({"catnm":catnm,"caticonnm":filename}).then((result)=>{
        res.render("addcategory",{"output":"Category added successfully....","sunm":req.session.sunm,"plist":"","count":count});   
     }).catch((err)=>{
        console.log(err);   
     });    
    }
 });
});
//==================================Add Product Category end ================================

//======================= Add Product Sub Category ==========================

router.get("/addsubcategory",(req,res)=>{
 res.render("addsubcategory",{"output":"","clist":clist,"sunm":req.session.sunm,"plist":"","count":count});
});


router.post("/addsubcategory",(req,res)=>{
 var catnm=req.body.catnm;
 var subcatnm=req.body.subcatnm;
 var caticon=req.files.caticon;
 var filename=Date.now()+"-"+caticon.name;
 var filepath=path.join(__dirname,"../public/uploads/subcategoryicons",filename);
 caticon.mv(filepath,(err)=>{
    if(err)
     res.render("addsubcategory",{"output":"SubCategory uploading failed....","clist":clist,"sunm":req.session.sunm,"plist":"","count":count});      
    else
    {
     // insert subcategory into database
     AdminController.addSubCategory({"catnm":catnm,"subcatnm":subcatnm,"subcaticonnm":filename}).then((result)=>{
        res.render("addsubcategory",{"output":"SubCategory added successfully....","clist":clist,"sunm":req.session.sunm,"plist":"","count":count});   
     }).catch((err)=>{
        console.log(err);   
     });    
    }
 });
});




//====================== Launch Product Start ===================== 


router.get("/launchp",(req,res)=>{
 res.render("launchp",{"sunm":req.session.sunm,"output1":"","output":"","clist":clist,"sclist":sclist,"scDetails":"","plist":"","count":count});
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
     res.render("launchp",{"output1":"Failed to Launch Product..!!","output":"","sunm":req.session.sunm,"output":"","clist":clist,"sclist":sclist,"scDetails":"","plist":"","count":count});      
    else
    {
     // insert tender details into database
     AdminController.addProduct(pDetails).then((result)=>{
            res.render("launchp",{"output":"Product Added Successfully !!","output1":"","sunm":req.session.sunm,"output":"","clist":clist,"sclist":sclist,"scDetails":"","plist":"","count":count});   
     }).catch((err)=>{
        console.log(err);   
     });    
    }
 });
});

//=============================Launch Product End =============================================  

//=============================Fetch & Manage Product Start==================================================  

 // Fetch your All products by perticular User
   router.get("/viewProducts",(req,res)=>{

   AdminController.fetchProduct({"owner":req.session.sunm}).then((result)=>{
      
      res.render("manageproducts",{"userDetails":result,"output":"","plist":"","count":count})

   }).catch((err)=>{
      console.log(err);
   });

})


//Get Perticular Product BY id to edit
   router.get("/editproduct/:_id",(req,res)=>{
            console.log(req.params._id)
            var _id = req.params._id
 AdminController.fetchProduct({"_id":req.params._id}).then((result)=>{
  console.log(result);
   res.render("editproduct",{"sunm":req.session.sunm,"output1":"","output":"","clist":clist,"sclist":sclist,"scDetails":"","pDetails":result[0],"plist":"","count":count});   
 }).catch((err)=>{
  console.log(err);   
 });   
});

router.post("/editproduct",(req,res)=>{
   
 var pDetails=req.body; 
 var uData={"catnm":pDetails.catnm,"suncatnm":pDetails.subcatnm,"description":pDetails.description,"price":pDetails.price,"pqty":pDetails.pqty};
 var cData={"title":pDetails.title};
         AdminController.productUpdateMaster(cData,uData).then((result)=>{
   res.render("editproduct",{"sunm":req.session.sunm,"output1":"","output":"Product Updated Successfully !!","clist":clist,"sclist":sclist,"scDetails":"","pDetails":result,"plist":"","count":count});
 
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

//======================Fetch & Manage Product End=============================

//=======================Profile Picture start ================================= 



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
     res.render("profilepicture",{"output":"Profile Picture uploading failed....","sunm":req.session.sunm,"plist":plist,"count":count});

    else
    {
     // insert category into database
     AdminController.addProfilepic({"piciconnm":filename,"username":sunm}).then((result)=>{
        res.render("profilepicture",{"output":"picture added successfully....","sunm":req.session.sunm,"plist":plist,"count":count});   
     }).catch((err)=>{
        console.log(err);   
     });    
    }
 });
});
//========================Profile Picture End =======================

//================================= Edit Profile Start ============================= 


router.get("/epadmin",(req,res)=>{
            
 AdminController.fetchUsers({"email":req.session.sunm}).then((result)=>{
   
   res.render("epadmin",{"sunm":req.session.sunm,"output":"","userDetails":result,"plist":"","count":count});   
 }).catch((err)=>{
  console.log(err);   
 });   
});

router.post("/epadmin",(req,res)=>{
      
 var userDetails=req.body; 
 var uData={"username":userDetails.username,"country":userDetails.country};
 var cData={"email":userDetails.email};
      AdminController.registerUpdateMaster(cData,uData).then((result)=>{

   res.render("epadmin",{"sunm":req.session.sunm,"output":"Profile Updated Successfully !!","userDetails":req.body,"plist":"","count":count}); 
 
 }).catch((err)=>{
   res.render("epadmin",{"sunm":req.session.sunm,"output":" Failed to update Profile !!","userDetails":req.body,"plist":"","count":count}); 
 
  console.log(err);    
 });   
});

//============= Edit Profile End ======================== 

export default router;




