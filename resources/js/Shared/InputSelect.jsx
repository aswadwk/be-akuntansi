import React from 'react'

const InputSelect = ({ label, placeholder, error, value, onChange, options, isRequired }) => {
    return (
        <>
            <label className={`form-label ${isRequired ? 'required' : ''}`}>{label}</label>
            <select
                onChange={onChange}
                value={value}
                className={`form-select ${error ? 'is-invalid' : ''}`}
                placeholder={placeholder}
            >
                <option value="">Choose {placeholder}</option>
                {
                    options.map((option) => (
                        <option key={option.value} value={option.value}>{option.label}</option>
                    ))
                }
            </select>
            {error && <div className="invalid-feedback">{error}</div>}
        </>
    )
}

export default InputSelect
