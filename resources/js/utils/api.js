import axios from "axios";
import Cookies from "js-cookie";

const API = axios.create({
    baseURL:
        import.meta.env.MODE === "production"
            ? "https://api.example.com"
            : "/api/v1",
    headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
    },
});

API.interceptors.request.use((config) => {
    const token = Cookies.get("token");
    if (token) config.headers.Authorization = `Bearer ${token}`;
    return config;
});

export async function apiGet(endpoint, params = {}) {
    try {
        const res = await API.get(endpoint, { params });
        return res.data;
    } catch (err) {
        handleError(err);
        throw err;
    }
}

export async function apiPost(endpoint, data = {}) {
    try {
        const res = await API.post(endpoint, data);
        return res.data;
    } catch (err) {
        handleError(err);
        throw err;
    }
}

function handleError(err) {
    if (err.response) {
        console.error("Error response:", err.response.data);
        alert(`Error: ${err.response.data.message}`);
    } else if (err.request) {
        console.error("Error request:", err.request);
        alert("Error: tidak ada response dari server");
    } else {
        console.error("Kesalahan:", err.message);
        alert(`Kesalahan: ${err.message}`);
    }
}
