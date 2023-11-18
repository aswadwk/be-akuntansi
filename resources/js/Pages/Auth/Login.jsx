import { useForm } from "@inertiajs/react";
import { useState } from "react";

const Login = () => {
    const [isShowing, setIsShowing] = useState(false);

    const { data, setData, post, processing, errors } = useForm({
        email: "",
        password: "",
        remember: false,
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post("/auth/login");
    };

    return (
        <div className="page page-center">
            <div className="container container-tight py-4 mt-4">
                <div className="text-center mb-4">
                    <a href="." className="navbar-brand navbar-brand-autodark">
                        <img
                            src="/logo.svg"
                            width="110"
                            height="32"
                            alt="Tabler"
                            className="navbar-brand-image"
                        />
                    </a>
                </div>
                <div className="card card-md">
                    <div className="card-body">
                        <h2 className="h2 text-center mb-4">
                            Login to your account
                        </h2>
                        <form onSubmit={handleSubmit}>
                            <div className="mb-3">
                                <label className="form-label">
                                    Email address
                                </label>
                                <input
                                    type="text"
                                    className={`${errors.email ? "is-invalid" : ""
                                        } form-control`}
                                    placeholder="your@email.com"
                                    autoComplete="off"
                                    value={data.email}
                                    onChange={(e) =>
                                        setData("email", e.target.value)
                                    }
                                />
                                <div className="invalid-feedback">
                                    {errors.email}
                                </div>
                            </div>
                            <div className="mb-2">
                                <label className="form-label">
                                    Password
                                    <span className="form-label-description">
                                        <a href="./forgot-password.html">
                                            I forgot password
                                        </a>
                                    </span>
                                </label>
                                <div className="input-group input-group-flat">
                                    <input
                                        type={isShowing ? "text" : "password"}
                                        className={`${errors.email ? "is-invalid" : ""
                                            } form-control`}
                                        placeholder="Your password"
                                        autoComplete="off"
                                        value={data.password}
                                        onChange={(e) =>
                                            setData("password", e.target.value)
                                        }
                                    />
                                    <span
                                        className="input-group-text"
                                        onClick={() => setIsShowing(!isShowing)}
                                    >
                                        <a
                                            href="#"
                                            className="link-secondary"
                                            data-bs-toggle="tooltip"
                                            aria-label="Show password"
                                            data-bs-original-title="Show password"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                className="icon"
                                                width="24"
                                                height="24"
                                                viewBox="0 0 24 24"
                                                strokeWidth="2"
                                                stroke="currentColor"
                                                fill="none"
                                                strokeLinecap="round"
                                                strokeLinejoin="round"
                                            >
                                                <path
                                                    stroke="none"
                                                    d="M0 0h24v24H0z"
                                                    fill="none"
                                                ></path>
                                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path>
                                            </svg>
                                        </a>
                                    </span>
                                </div>
                            </div>
                            <div className="mb-2">
                                <label className="form-check">
                                    <input
                                        type="checkbox"
                                        value={data.remember}
                                        onChange={(e) =>
                                            setData(
                                                "remember",
                                                e.target.checked,
                                            )
                                        }
                                        className="form-check-input"
                                    />
                                    <span className="form-check-label">
                                        Remember me on this device
                                    </span>
                                </label>
                            </div>
                            <div className="form-footer">
                                <button
                                    type="submit"
                                    className="btn btn-primary w-100"
                                >
                                    Sign in
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Login;
