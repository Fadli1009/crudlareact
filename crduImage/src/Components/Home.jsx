import Footer from "./Footer";
import Navbar from "./Navbar";
import TableProduct from "./TableProduct";

const Home = () => {
    return (
        <>
            <Navbar />
            <div className="px-5 lg:px-[75px] py-5">
                <div className="font-bold text-2xl  text-center">
                    <h1>Crud made by React and Laravel</h1>
                </div>
                <TableProduct />
            </div>
            <Footer />
        </>
    );
}

export default Home;