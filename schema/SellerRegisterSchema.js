import mongoose from 'mongoose';
import uniqueValidator from 'mongoose-unique-validator';


const SellerRegisterSchema = mongoose.Schema({

_id:Number,
username:String,
email:String,
country:String,
password:String


},{ strict: false })



SellerRegisterSchema.plugin(uniqueValidator); 

const SellerRegisterSchemaModel = mongoose.model('seller_tmp',SellerRegisterSchema,'Sellers'); 




export default SellerRegisterSchemaModel