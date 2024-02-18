import React from 'react'
import { SelectPicker } from 'rsuite'

const InputSelectWithSearch = ({ label, placeholder, error, value, onChange, options, isRequired }) => {
    return (
        <>
            {label && (
                <label className={`form-label ${isRequired ? 'required' : ''}`}>{label}</label>
            )}
            <SelectPicker
                data={options}
                placeholder={placeholder}
                value={value}
                onChange={onChange}
                className={`w-full ${error ? "is-invalid rs-picker-error" : ""}`}
            />
            <div className="invalid-feedback">
                {error}
            </div>
        </>
    )
}

export default InputSelectWithSearch
