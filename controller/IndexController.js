import IndexModel from '../models/IndexModel.js';
import AdminModel from '../models/AdminModel.js';
import crypto from 'crypto'; 
import {hashPassword, comparePassword} from '../schema/helper.js';
import FacebookSchemaModel from '../schema/FacebookSchema.js';

class IndexController 
{
 registerUser(userDetails,cb)
 {
  return new Promise((resolve,reject)=>{
    IndexModel.getUsers({}).then((result)=>{
     var l=result.length;
     var _id=(l==0)?1:result[l-1]._id+1;
     userDetails={...userDetails,"_id":_id,"status":0,"role":"user","info":Date()}   
     IndexModel.registerUserModel(userDetails).then((result)=>{
        resolve(result);    
     }).catch((err)=>{
        reject(err);            
     });   
    }).catch((err)=>{
     reject(err);    
    });
  })   
 }


registerSeller(userDetails,cb)
 {
  return new Promise((resolve,reject)=>{
    IndexModel.getSellers({}).then((result)=>{
     var l=result.length;
     var _id=(l==0)?1:result[l-1]._id+1;
     userDetails={...userDetails,"_id":_id,"status":0,"role":"seller","info":Date()}   
     IndexModel.registerSellerModel(userDetails).then((result)=>{
        resolve(result);    
     }).catch((err)=>{
        reject(err);            
     });   
    }).catch((err)=>{
     reject(err);    
    });
  })   
 }


 userLogin(userDetails)
 {
   userDetails={...userDetails,"status":1};
   return new Promise((resolve,reject)=>{

    const {email,password,status} = userDetails; 
    IndexModel.fetchUsers(userDetails).then((result)=>{
      var l=result.length;
      var s=(l==0)?0:((result.role=="admin")?1:(result.role=="seller")?2:(result.role=="user")?3:4);

      const isValid = comparePassword(password, result.password);

           if(isValid)
            {
             resolve({"s":s,"userDetails":result});    
            }
            else 
            {
              resolve({"s":0,"userDetails":result});
            }
    }).catch((err)=>{
      reject(err);  
    });   
   });
 }

 //============================= Login with Facebook Start========================================= 

   registerFacebookUser(userDetails){

    return new Promise((resolve,reject)=>{

       IndexModel.getUsers1({"uid":userDetails.id}).then((result)=>{
          resolve(result)
                 
        if(result)
        {
            console.log("user Found ")
              FacebookSchemaModel.updateOne({"uid":userDetails.id},{"info":Date.now()})
        }
        else 
        {
           console.log("user not Found ")
      var token = crypto.randomBytes(32).toString("hex");
     userDetails={...userDetails,"uid":userDetails.id ,"role":"user","info":Date.now(),"token":token}
      IndexModel.registerFacebookUserModel(userDetails).then((result)=>{
          resolve(result); 
      }).catch((err)=>{
          reject(err);
      })
         
        }


       }).catch((err)=>{

       })
    })
 }


 //================================Login with Facebook End===================================
 

 //===========================Fetch Product Start ==============================================

 fetchProducts(condition_obj)
 {
   return new Promise((resolve,reject)=>{
    AdminModel.fetchProduct(condition_obj).then((result)=>{
      resolve(result);      
    }).catch((err)=>{
      reject(err);  
    });   
   });
 }

}

export default new IndexController();