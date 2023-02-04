//Require Mongoose
import mongoose from 'mongoose';
import uniqueValidator from 'mongoose-unique-validator';

const SubCategorySchema = mongoose.Schema({
  _id: Number,
  catnm: {
    type: String,
    required: [true,"Category is required"],
    lowercase: true,
    trim: true,
  },
  subcatnm: {
    type: String,
    required: [true,"SubCategory is required"],
    lowercase: true,
    unique: true,
    trim: true,
  },
  subcaticonnm: {
    type: String,
    required: [true,"SubCategory icon is required"],
    trim: true
  }
});

// Apply the uniqueValidator plugin to RegisterSchema.
SubCategorySchema.plugin(uniqueValidator);

// compile schema to model
const SubCategorySchemaModel = mongoose.model('subcat_tmp', SubCategorySchema ,'subcategory');

export default SubCategorySchemaModel