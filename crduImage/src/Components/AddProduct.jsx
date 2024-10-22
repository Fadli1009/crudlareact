import { useState } from "react";
import Footer from "./Footer";
import Navbar from "./Navbar";
import axios from "axios";

const AddProduct = () => {
    const [title, setTitle] = useState('')
    const [descriptions, setDescriptions] = useState('')
    const [price, setPrice] = useState('')
    const [location, setLocation] = useState('')
    const [bedrooms, setBedrooms] = useState('')
    const [bathrooms, setBathrooms] = useState('')
    const [area, setArea] = useState('')
    const [status, setStatus] = useState(1)
    const [userId, setUserId] = useState(1)
    const [image, setImage] = useState(null)
    const handleFile = (e) => {
        setImage(e.target.files[0])
    }
    const upload = async () => {
        const formData = new FormData()
        formData.append('title', title)
        formData.append('descriptions', descriptions)
        formData.append('price', price)
        formData.append('location', location)
        formData.append('bedrooms', bedrooms)
        formData.append('bathrooms', bathrooms)
        formData.append('area', area)
        formData.append('image', image)
        formData.append('status', status)
        formData.append('user_id', userId)

        try {
            const response = await axios.post('http://127.0.0.1:8000/api/house', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            console.log(response);

        } catch (error) {
            console.error("error", error);
        }
        if (response) {
            console.log(response);
        }
    }

    const handleSubmit = async (e) => {
        e.preventDefault()
        await upload()

    }

    return (
        <>
            <Navbar />
            <div className="px-5 lg:px-[75px] py-5">
                <div className="font-bold text-2xl  text-center">
                    <h1>Add Product</h1>
                </div>
                {/* Form to add product */}

                <div className="mt-5">
                    <form className="space-y-5" onSubmit={handleSubmit}>
                        <div className="grid grid-cols-2 gap-2">
                            <div className="text-xl font-semibold">Title</div>
                            <div className="w-full block">
                                <input className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Title" onChange={(e) => setTitle(e.target.value)} />
                            </div>
                            <input type="hidden" value={status} />
                            <input type="hidden" value={userId} />
                        </div>
                        <div className="grid grid-cols-2 gap-2">
                            <div className="text-xl font-semibold">Descriptions</div>
                            <div className="w-full block">
                                <input className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="desc" type="text" placeholder="Descriptions" onChange={(e) => setDescriptions(e.target.value)} />
                            </div>
                        </div>
                        <div className="grid grid-cols-2 gap-2">
                            <div className="text-xl font-semibold">Price</div>
                            <div className="w-full block">
                                <input className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="price" type="text" placeholder="Price" onChange={(e) => setPrice(e.target.value)} />
                            </div>
                        </div>
                        <div className="grid grid-cols-2 gap-2">
                            <div className="text-xl font-semibold">Location</div>
                            <div className="w-full block">
                                <input className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="loc" type="text" placeholder="Location" onChange={(e) => setLocation(e.target.value)} />
                            </div>
                        </div>
                        <div className="grid grid-cols-2 gap-2">
                            <div className="text-xl font-semibold">Bedrooms</div>
                            <div className="w-full block">
                                <input className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="bed" type="number" placeholder="Bedrooms" onChange={(e) => setBedrooms(e.target.value)} />
                            </div>
                        </div>
                        <div className="grid grid-cols-2 gap-2">
                            <div className="text-xl font-semibold">Bathrooms</div>
                            <div className="w-full block">
                                <input className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="bath" type="number" placeholder="Bathrooms" onChange={(e) => setBathrooms(e.target.value)} />
                            </div>
                        </div>
                        <div className="grid grid-cols-2 gap-2">
                            <div className="text-xl font-semibold">Area</div>
                            <div className="w-full block">
                                <input className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="area" type="text" placeholder="Luas Area" onChange={(e) => setArea(e.target.value)} />
                            </div>
                        </div>
                        <div className="grid grid-cols-2 gap-2">
                            <div className="text-xl font-semibold">Image</div>
                            <div className="w-full block">
                                <input className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="image" type="file" placeholder="images" onChange={handleFile} />
                            </div>
                        </div>
                        <div className="flex justify-end">
                            <button type="submit" className="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Add Product</button>
                        </div>
                    </form>
                </div>
            </div>
            <Footer />
        </>
    );
}

export default AddProduct;