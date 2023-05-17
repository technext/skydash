//Require Mongoose
import mongoose from 'mongoose';
import uniqueValidator from 'mongoose-unique-validator';

const ProfilepicSchema = mongoose.Schema({
  _id: Number,
   piciconnm: {
    type: String,
    required: [true,"Category icon is required"],
    trim: true
  },
  username:String
});

// Apply the uniqueValidator plugin to RegisterSchema.
ProfilepicSchema.plugin(uniqueValidator);

// compile schema to model
const ProfilepicSchemaModel = mongoose.model('pic_tmp', ProfilepicSchema ,'profilepic');

export default ProfilepicSchemaModel