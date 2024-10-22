import axios from "axios";
import { useEffect, useState } from "react";
import { Navigate, useNavigate } from "react-router-dom";

const TableProduct = () => {

    const [product, setProducts] = useState([])
    const [loading, setLoading] = useState(true)
    const getProduct = async () => {
        try {
            const response = await axios.get('http://127.0.0.1:8000/api/house')
            setProducts(response.data.data)

        } catch (error) {
            console.error(error);
        } finally {
            setLoading(false)
        }

    }
    useEffect(() => {
        getProduct()
    }, [])

    const addProducts = useNavigate()
    const addProduct = () => {
        addProducts('/addProduct')
    }

    if (loading) {
        return (
            <div className="relative h-screen">
                <div className="absolute inset-0 flex items-center justify-center">
                    <div className="animate-spin rounded-full h-32 w-32 border-b-2 border-blue-500"></div>
                </div>
            </div>
        );
    }

    return (
        <>
            <div className="lg:px-[75px] py-5">
                <button onClick={addProduct} className="bg-green-500 px-5 p-2 text-white hover:bg-green-600 rounded">Add House</button>

                <table className="table-auto w-full mt-5">
                    <thead>
                        <tr className="text-center">
                            <th>no</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Lokasi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {product.map((item, index) => (
                            <tr className="text-center">
                                <td>{index + 1}</td>
                                <td>{item.title}</td>
                                <td>{item.price.toLocaleString()}</td>
                                <td>{item.location}</td>
                                <td>

                                    <button onClick={() => {
                                        console.log(item.id);
                                        // deleteProduct(item.id)
                                    }}>Delete</button>
                                    <button onClick={() => {
                                        console.log(item.id);
                                        // editProduct(item.id)
                                    }}>Edit</button>
                                </td>
                            </tr>
                        ))}


                    </tbody>
                </table>
            </div>
        </>
    );
}

export default TableProduct;