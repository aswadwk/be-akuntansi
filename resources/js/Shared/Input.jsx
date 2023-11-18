import React from 'react'

const Input = ({ label, onChange, error, value, placeholder }) => {
    return (
        <>
            <label className="form-label">{label}</label>
            <input
                onChange={onChange}
                value={value}
                type="text"
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
