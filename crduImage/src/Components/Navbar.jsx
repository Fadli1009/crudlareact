import { Link } from "react-router-dom";
import Home from "./Home";
import AddProduct from "./AddProduct";

const Navbar = () => {
    return (
        <>
            <nav className="flex justify-between w-full bg-slate-600 items-center text-white px-5 py-3">
                <div>
                    <h1>CRUD RL.</h1>
                </div>
                <div>
                    <ul className="flex space-x-3">
                        <li><Link to='/'>Home</Link></li>
                        <li><Link to='/addProduct'>Add Product</Link></li>
                    </ul>
                </div>
            </nav>
        </>
    );
}

export default Navbar;