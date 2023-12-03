import React, { useState } from 'react'
import Input from '../../Shared/Input'
import { useForm } from '@inertiajs/react'
import Layout from '../../Shared/Layout'

const ChangePassword = () => {
    const { data, setData, put, errors, } = useForm({
        current_password: "",
        new_password: "",
        new_password_confirmation: "",
    })

    const [isShowing, setIsShowing] = useState({
        current_password: false,
        new_password: false,
        new_password_confirmation: false,
    })

    const onSubmit = (e) => {
        e.preventDefault()

        if (data.new_password !== data.new_password_confirmation) {
            alert("Password doesn't match")
            return
        }

        e.preventDefault()
        put("/auth/change-password")
    }

    return (
        <Layout>
            <div className="col-12 col-md-6">
                <form onSubmit={onSubmit}>
                    <div className="card">
                        <div className="card-body">
                            <div className="mb-3">
                                <label className="form-label">
                                    Current Password
                                </label>
                                <div className="input-group input-group-flat">
                                    <input
                                        type={isShowing.current_password ? "text" : "password"}
                                        className={`${errors.current_password ? "is-invalid" : ""
                                            } form-control`}
                                        placeholder="Your password"
                                        autoComplete="off"
                                        value={data.current_password}
                                        onChange={(e) =>
                                            setData("current_password", e.target.value)
                                        }
                                    />
                                    <span
                                        className="input-group-text"
                                        onClick={() => setIsShowing({
                                            ...isShowing,
                                            current_password: !isShowing.current_password
                                        })}
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
                            <div className="mb-3">
                                <label className="form-label">
                                    New Password
                                </label>
                                <div className="input-group input-group-flat">
                                    <input
                                        type={isShowing.new_password ? "text" : "password"}
                                        className={`${errors.new_password ? "is-invalid" : ""
                                            } form-control`}
                                        placeholder="Your password"
                                        autoComplete="off"
                                        value={data.new_password}
                                        onChange={(e) =>
                                            setData("new_password", e.target.value)
                                        }
                                    />
                                    <span
                                        className="input-group-text"
                                        onClick={() => setIsShowing({
                                            ...isShowing,
                                            new_password: !isShowing.new_password
                                        })}
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
                            <div className="mb-3">
                                <label className="form-label">
                                    New Password Confirmation
                                </label>
                                <div className="input-group input-group-flat">
                                    <input
                                        type={isShowing.new_password_confirmation ? "text" : "password"}
                                        className={`${errors.new_password_confirmation ? "is-invalid" : ""
                                            } form-control`}
                                        placeholder="Your password"
                                        autoComplete="off"
                                        value={data.new_password_confirmation}
                                        onChange={(e) =>
                                            setData("new_password_confirmation", e.target.value)
                                        }
                                    />
                                    <span
                                        className="input-group-text"
                                        onClick={() => setIsShowing({
                                            ...isShowing,
                                            new_password_confirmation: !isShowing.new_password_confirmation
                                        })}
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

                        </div>
                        <div className="card-footer text-end">
                            <button type='submit' className='btn btn-primary'>Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </Layout>
    )
}

export default ChangePassword
