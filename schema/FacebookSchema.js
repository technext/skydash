import mongoose from 'mongoose';
import uniqueValidator from 'mongoose-unique-validator';


const FacebookSchema = mongoose.Schema({},{ strict: false })



FacebookSchema.plugin(uniqueValidator); 

const FacebookSchemaModel = mongoose.model('facebook_tmp',FacebookSchema,'register'); 




export default FacebookSchemaModel