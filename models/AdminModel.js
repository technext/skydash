import './connection.js';

import RegisterSchemaModel from '../schema/RegisterSchema.js';
import CategorySchemaModel from '../schema/CategorySchema.js';
import SubCategorySchemaModel from '../schema/SubCategorySchema.js';
import ProductSchemaModel from '../schema/ProductSchema.js';
import ProfilepicSchemaModel from '../schema/ProfilepicSchema.js';
class AdminModel
{
 
 registerUpdateMasterModel(cdata,udata){

 	return new Promise((resolve,reject)=>{

 		RegisterSchemaModel.update(cdata,udata,(err,result)=>{
                
 			err? reject(err) : resolve(result);
 		})

 	})

 }


  manageUsers(condition_obj)
 {
  return new Promise((resolve,reject)=>{
  
    RegisterSchemaModel.find(condition_obj,(err,result)=>{
      err ? reject(err) : resolve(result);        
    })    
  }) 
 }


manageUserStatusModel(sDetails){
        return new Promise((resolve,reject)=>{
            if(sDetails.status=="block")
                    {
                RegisterSchemaModel.update({"_id":parseInt(sDetails._id)},{"status":0},(err,result)=>{
                err ? reject(err) : resolve(result);     
                });
            }
      else if(sDetails.status=="verify")
      {
        RegisterSchemaModel.update({"_id":parseInt(sDetails._id)},{"status":1},(err,result)=>{
          err ? reject(err) : resolve(result);   

        });
      }
      else
      {
        RegisterSchemaModel.remove({"_id":parseInt(sDetails._id)},(err,result)=>{
          err ? reject(err) : resolve(result);
        });
      }
    }); 
}




//====================Add Category Start 

fetchCategory(condition_obj)
 {
  return new Promise((resolve,reject)=>{
    CategorySchemaModel.find(condition_obj,(err,result)=>{
      err ? reject(err) : resolve(result);        
    })    
  }) 
 }


 addCategoryModel(cDetails)
 {
  return new Promise((resolve,reject)=>{
    var obj = new CategorySchemaModel(cDetails);
     
    
    obj.save((err,result)=>{
      err ? reject(err) : resolve(result) ;            
    });
  
  });
 }
//========================= Add Category End================

//=========Add Product Subcategory Start================== 
  addSubCategoryModel(scDetails)
 {
  return new Promise((resolve,reject)=>{
    // a document instance
    var obj = new SubCategorySchemaModel(scDetails);
     
    // save model to database
    obj.save((err,result)=>{
      err ? reject(err) : resolve(result) ;            
    });
  
  });
 }

 fetchSubCategory(condition_obj)
 {
  return new Promise((resolve,reject)=>{
    SubCategorySchemaModel.find(condition_obj,(err,result)=>{
      err ? reject(err) : resolve(result);        
    })    
  }) 
 }

//=================Add Product Sub Category End======================


 //==================Launch Product Start =================== 

 addProductModel(pDetails)
 {
  return new Promise((resolve,reject)=>{
    // a document instance
    var obj = new ProductSchemaModel(pDetails);
     
    // save model to database
    obj.save((err,result)=>{
      err ? reject(err) : resolve(result) ;            
    });
  
  });  
 }



//==================Launch Product End========================


//===================Fetch & manage products Start ============= 


 fetchProduct(condition_obj)
 {
  return new Promise((resolve,reject)=>{
    ProductSchemaModel.find(condition_obj,(err,result)=>{
      err ? reject(err) : resolve(result);        
    })    
  }) 
 }

   productUpdateMasterModel(cData,uData)
  {
    return new Promise((resolve,reject)=>{
        // to update data in collection
        ProductSchemaModel.update(cData,uData,(err,result)=>{
          err ? reject(err) : resolve(result);        
        });
    });  
  }


  manageProductStatusModel(pDetails){
        return new Promise((resolve,reject)=>{
            if(pDetails.status=="delete")
                    {
                 ProductSchemaModel.remove({"_id":parseInt(pDetails._id)},(err,result)=>{
          err ? reject(err) : resolve(result);
        });
            }
    }); 
}
//===============================================Fetch & Manage Product end =============================

//================================Profile Picture Start ================================= 


  fetchProfilepic(condition_obj)
 {
  return new Promise((resolve,reject)=>{
    ProfilepicSchemaModel.find(condition_obj,(err,result)=>{
      err ? reject(err) : resolve(result);        
    })    
  }) 
 }


 addProfilepicModel(picDetails)
 {
  return new Promise((resolve,reject)=>{
        var obj = new ProfilepicSchemaModel(picDetails);
      ProfilepicSchemaModel.findOne({"username":picDetails.username},(err,result)=>{
        console.log(result); 
        console.log(err);
      if(!result)
            {        
                  obj.save(()=>{
                    resolve(result) ;            
                  });
            }
      else
      {

          ProfilepicSchemaModel.update({"username":picDetails.username},{"piciconnm":picDetails.piciconnm},(err,result)=>{
            if(result)
            {          
              console.log("updated")
              resolve(result);
            } 
          })
            
      }      
    })  

    });
 }


//================================================Profile Picture End ======================

}

export default new AdminModel();