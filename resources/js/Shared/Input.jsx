import React from 'react'

const Input = ({ label, onChange, error, value, placeholder, type = 'text', isRequired }) => {
    return (
        <>
            <label className={`form-label ${isRequired ? 'required' : ''}`}>{label}</label>
            <input
                onChange={onChange}
                value={value}
                type={type}
                className={`form-control ${error ? "is-invalid" : ""}`}
                placeholder={placeholder}
            />
            <div className="invalid-feedback">
                {error}
            </div>
        </>
    )
}

export default Input
