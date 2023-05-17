import './connection.js';
import RegisterSchemaModel from '../schema/RegisterSchema.js';
import SellerRegisterSchemaModel from '../schema/SellerRegisterSchema.js';
import {hashPassword, comparePassword} from '../schema/helper.js';
import FacebookSchemaModel from '../schema/FacebookSchema.js';
class IndexModel {


//==================Register User/Admin =================
 registerUserModel(userDetails)
 {
  return new Promise((resolve,reject)=>{

userDetails.password = hashPassword(userDetails.password);

    var obj = new RegisterSchemaModel(userDetails);
     
    
    obj.save((err,result)=>{
      err ? reject(err) : resolve(result) ;            
    });
  
  });
 }


//=====================Register Seller =========================
registerSellerModel(userDetails)
 {
  return new Promise((resolve,reject)=>{

userDetails.password = hashPassword(userDetails.password);

    var obj = new RegisterSchemaModel(userDetails);
     
    
    obj.save((err,result)=>{
      err ? reject(err) : resolve(result) ;            
    });
  
  });
 }


fetchUsers(userDetails)
 {
    
      return new Promise((resolve,reject)=>{

        const {email,password,status} = userDetails; 

        RegisterSchemaModel.findOne({email,status},(err,result)=>{
                   err ? reject(err) : resolve(result) ;           
  
        })

         
    })

 }

//============================ Store Facebook User 
  registerFacebookUserModel(userDetails)
 {
  return new Promise((resolve,reject)=>{

      var obj = new FacebookSchemaModel(userDetails);
    
    obj.save((err,result)=>{

            err ? reject(err) : resolve(result) ;            
    });
  });  
 }

  updateFacebookUserModel(userDetails){

  return new Promise((resolve,reject)=>{

    FacebookSchemaModel.updateOne({"uid":userDetails.id},{"info":Date.now()},(err,result)=>{

      err? reject(err) : resolve(result);
    })

  })

 }

  getUsers1(condition_obj)
 {
  return new Promise((resolve,reject)=>{
  
    RegisterSchemaModel.findOne(condition_obj,(err,result)=>{
      err ? reject(err) : resolve(result);        
    })    
  }) 
 }
//========================= Store FB User End========================


//==================Fetch User/Admin/Seller ==========================

  getUsers(condition_obj)
 {
  return new Promise((resolve,reject)=>{
  
    RegisterSchemaModel.find(condition_obj,(err,result)=>{
      err ? reject(err) : resolve(result);        
    })    
  }) 
 }

   getSellers(condition_obj)
 {
  return new Promise((resolve,reject)=>{
  
    RegisterSchemaModel.find(condition_obj,(err,result)=>{
      err ? reject(err) : resolve(result);        
    })    
  }) 
 }
//=============================================Admin/Seller Registration End ==========================

}
export default new IndexModel();