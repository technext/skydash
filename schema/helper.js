import bcrypt from 'bcryptjs';

 function hashPassword(password){

	const salt = bcrypt.genSaltSync(); 
	return bcrypt.hashSync(password, salt); 

}

function comparePassword(raw, hash){

	return bcrypt.compareSync(raw, hash)
}

export {hashPassword, comparePassword }