import IndexModel from '../models/IndexModel.js';
import AdminModel from '../models/AdminModel.js';

class AdminController 
{


registerUpdateMaster(cdata,udata){

	return new Promise((resolve,reject)=>{

		AdminModel.registerUpdateMasterModel(cdata,udata).then((result)=>{

				resolve(result); 

		}).catch((err)=>{

				reject(err);

		});

	})


}

 fetchUsers(condition_obj){
      return new Promise((resolve,reject)=>{

          IndexModel.getUsers1(condition_obj).then((result)=>{
              resolve(result);
          }).catch((err)=>{

            reject(err);
          });

      })

    }

//========================User management Start ===================

 fetchUsers1(condition_obj)
 {
   return new Promise((resolve,reject)=>{
    IndexModel.getUsers(condition_obj).then((result)=>{
      resolve(result);      
    }).catch((err)=>{
      reject(err);  
    });   
   });
 }



 manageUserStatus(sDetails){

  return new Promise((resolve,reject)=>{
    AdminModel.manageUserStatusModel(sDetails).then((result)=>{
        resolve(result);
    }).catch((err)=>{
      reject(err); 
    });
  })
 }



//=================== User Management End ========================

 //==============Add Category Start 
  addCategory(cDetails)
 {
  return new Promise((resolve,reject)=>{
    AdminModel.fetchCategory({}).then((result)=>{
     var l=result.length;
     var _id=(l==0)?1:result[l-1]._id+1;
     cDetails={...cDetails,"_id":_id}   
     AdminModel.addCategoryModel(cDetails).then((result)=>{
        resolve(result);    
     }).catch((err)=>{
        reject(err);            
     });   
    }).catch((err)=>{
     reject(err);    
    });
  }) 
 }

 fetchCategory(condition_obj)
 {
   return new Promise((resolve,reject)=>{
    AdminModel.fetchCategory(condition_obj).then((result)=>{
      resolve(result);      
    }).catch((err)=>{
      reject(err);  
    });   
   });
 }
//============add Category End========

//=================Add Product Sub Category Start===============================
  addSubCategory(scDetails)
 {
  return new Promise((resolve,reject)=>{
    AdminModel.fetchSubCategory({}).then((result)=>{
     var l=result.length;
     var _id=(l==0)?1:result[l-1]._id+1;
     scDetails={...scDetails,"_id":_id}   
     AdminModel.addSubCategoryModel(scDetails).then((result)=>{
        resolve(result);    
     }).catch((err)=>{
        reject(err);            
     });   
    }).catch((err)=>{
     reject(err);    
    });
  }) 
 }

  
 //=================== Product Sub Cat End =============

 //===================== Launch Prouduct Start =============== 

  addProduct(pDetails)
 {
  return new Promise((resolve,reject)=>{
    AdminModel.fetchProduct({}).then((result)=>{
     var l=result.length;
     var _id=(l==0)?1:result[l-1]._id+1;
     pDetails={...pDetails,"_id":_id,"type":"product","info":Date()}   
     AdminModel.addProductModel(pDetails).then((result)=>{
        resolve(result);    
     }).catch((err)=>{
        reject(err);            
     });   
    }).catch((err)=>{
     reject(err);    
    });
  }) 
 }

fetchSubCategory(condition_obj)
 {
   return new Promise((resolve,reject)=>{
    AdminModel.fetchSubCategory(condition_obj).then((result)=>{
      resolve(result);      
    }).catch((err)=>{
      reject(err);  
    });   
   });
 }
//====================================== Launch Product End==============================

 //=========================View & Manage Products =====================================


  fetchProduct(condition_obj){

    return new Promise((resolve,reject)=>{
            AdminModel.fetchProduct(condition_obj).then((result)=>{
                resolve(result)
            }).catch((err)=>{
                reject(err)
            })
    })

 }


 productUpdateMaster(cData,uData)
 {
  return new Promise((resolve,reject)=>{
    AdminModel.productUpdateMasterModel(cData,uData).then((result)=>{
      resolve(result);    
    }).catch((err)=>{
      reject(err);
    });
  }); 
 }


  manageProductStatus(pDetails){

  return new Promise((resolve,reject)=>{
    AdminModel.manageProductStatusModel(pDetails).then((result)=>{
        resolve(result);
    }).catch((err)=>{
      reject(err); 
    });
  })
 }


 //=================================== Fetch product end================

 //==================Profile Picture Start=========================== 

 addProfilepic(picDetails)
 {
  return new Promise((resolve,reject)=>{
    AdminModel.fetchProfilepic({}).then((result)=>{
     var l=result.length;
     var _id=(l==0)?1:result[l-1]._id+1;
     picDetails={...picDetails,"_id":_id}   
     AdminModel.addProfilepicModel(picDetails).then((result)=>{
        resolve(result);    
     }).catch((err)=>{
        reject(err);            
     });   
    }).catch((err)=>{
     reject(err);    
    });
  }) 
 }


fetchProfilepic(condition_obj)
 {
   return new Promise((resolve,reject)=>{
    AdminModel.fetchProfilepic(condition_obj).then((result)=>{
      resolve(result);      
    }).catch((err)=>{
      reject(err);  
    });   
   });
 }
//================== Profie Pic End ========================

 //=============== Edit Profile Start ======================= 

 registerUpdateMaster(cData,uData)
 {
  return new Promise((resolve,reject)=>{
    AdminModel.registerUpdateMasterModel(cData,uData).then((result)=>{
      resolve(result);    
    }).catch((err)=>{
      reject(err);
    });
  }); 
 }

}

export default new AdminController();