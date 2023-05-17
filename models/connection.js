import mongoose from 'mongoose';

const url="mongodb://localhost:27017/AdminSecurity"
mongoose.set('strictQuery',false) 
mongoose.connect(url);
console.log("connected to database.");  




/* import mongoose from 'mongoose';
const url="mongodb://localhost:27017/vasu1"
mongoose.set('strictQuery',true) 
mongoose.connect(url);
console.log("Successfully connected to mongodb database....");

*/
