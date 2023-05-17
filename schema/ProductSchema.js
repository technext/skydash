//Require Mongoose
import mongoose from 'mongoose';
import uniqueValidator from 'mongoose-unique-validator';

const ProductSchema = mongoose.Schema({
  _id: Number,
  title: {
    type: String,
    required: [true,"Product Title is required"],
    lowercase: true,
    trim: true,
  },
   catnm: {
    type: String,
    required: [true,"Product Category is required"],
    lowercase: true,
    trim: true
  },
  subcatnm: {
    type: String,
    required: [true,"Product SubCategory is required"],
    lowercase: true,
    trim: true
  },
  description: {
    type: String,
    required: [true,"Product Description is required"],
    trim: true
  },
  pimgname: {
    type: String,
    required: [false,"Product Image is required"],
    trim: true
  },
  price: {
    type: Number,
    required: [true,"Product Price is required"],
    trim: true
  },
   pqty: {
    type: Number,
    required: [false,"Quantity is required"],
    trim: true
  },
  info: String,
  type:String,
  owner:String
});

// Apply the uniqueValidator plugin to RegisterSchema.
ProductSchema.plugin(uniqueValidator);

// compile schema to model
const ProductSchemaModel = mongoose.model('p_tmp', ProductSchema ,'Products');

export default ProductSchemaModel