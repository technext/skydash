import mongoose from 'mongoose';
import uniqueValidator from 'mongoose-unique-validator';


const RegisterSchema = mongoose.Schema({

_id:Number,
username:String,
email:String,
country:String,
password:String


},{ strict: false })



RegisterSchema.plugin(uniqueValidator); 

const RegisterSchemaModel = mongoose.model('reg_tmp',RegisterSchema,'register'); 




export default RegisterSchemaModel