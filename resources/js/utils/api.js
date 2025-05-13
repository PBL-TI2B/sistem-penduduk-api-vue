import axios from "axios";
import Cookies from "js-cookie";
import { toast } from "vue-sonner";

const API = axios.create({
    baseURL:
        import.meta.env.MODE === "production"
            ? "https://api.example.com"
            : "/api/v1",
    headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
    },
    withCredentials: true,
});

API.interceptors.request.use((config) => {
    const token = Cookies.get("token");
    if (token) config.headers.Authorization = `Bearer ${token}`;
    return config;
});

export async function apiGet(endpoint, params = {}, config = {}) {
    try {
        const res = await API.get(endpoint, {
            params,
            ...config,
        });
        return res.data;
    } catch (err) {
        errorHandler(err);
        throw err;
    }
}

export async function apiPost(endpoint, data = {}, params = {}, config = {}) {
    try {
        const res = await API.post(endpoint, data, {
            ...config,
            headers: {
                "Content-Type": "multipart/form-data",
                ...(config.headers || {}),
            },
        });
        return res.data;
    } catch (err) {
        errorHandler(err);
        throw err;
    }
}

function errorHandler(err) {
    if (err.response) {
        console.error("Error response:", err.response.data);
        toast.error(`Error: ${err.response.data.message}`);
    } else if (err.request) {
        console.error("Error request:", err.request);
        toast.error("Error: tidak ada response dari server");
    } else {
        console.error("Kesalahan:", err.message);
        toast.error(`Kesalahan: ${err.message}`);
    }
}
