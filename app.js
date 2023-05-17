import express from 'express';
import * as path from 'path';
import * as url from 'url';
import bodyParser from 'body-parser';
import fileUpload from 'express-fileupload';
//import Stripe from 'stripe';
import cookie from 'cookie-parser';
import Paytm from 'paytm-pg-node-sdk';
import session from 'express-session';
import IndexModel from './models/IndexModel.js';
import dotenv from 'dotenv';
const port = process.env.PORT || 3000;


const app = express();
const __dirname = url.fileURLToPath(new URL('.', import.meta.url));
import IndexRouter from './routes/IndexRouter.js';
import AdminRouter from './routes/AdminRouter.js';
import UserRouter from './routes/UserRouter.js';
import SellerRouter from './routes/SellerRouter.js'; 
//============================Middleware Section ================================== 
app.use(express.json());
app.use(cookie());
app.use(Paytm());

app.use(bodyParser());
//app.use(bodyParser.json());
app.use(bodyParser.urlencoded({extended: false}));


app.use(bodyParser.json());
 
app.use(session({"secret":"kilvish"}));
app.use(fileUpload());

app.use("/admin",AdminRouter);
app.use("/user",UserRouter);
app.use("/seller",SellerRouter);
app.use("/",IndexRouter);

app.use(express.static(path.join(__dirname, 'public')));
//===============================================================================

app.set("view engine","ejs");
app.set("views", [
		path.join(__dirname,"./views"),
		path.join(__dirname,"./views/admin/"),
		path.join(__dirname,"./views/web/"),
		
	]  );





app.listen(port, () => console.log(`Listening on port ${port}...`));
//app.listen(3000);
console.log("Admin Security Panel Started at local host");