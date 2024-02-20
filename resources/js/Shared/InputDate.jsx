import React from 'react'
import { DatePicker } from 'rsuite'
import addDays from 'date-fns/addDays';

const predefinedBottomRanges = [
    {
        label: 'Kemarin',
        value: addDays(new Date(), -1),
    },
    {
        label: 'Hari ini',
        value: new Date(),
    },
];

const InputDate = ({ label, onChange, error, value, placeholder, type = 'text', isRequired, format }) => {
    return (
        <>
            <label className={`form-label ${isRequired ? 'required' : ''}`}>{label}</label>
            <DatePicker
                oneTap
                format={format}
                value={value}
                className={`w-full ${error ? "is-invalid rs-picker-error" : ""}`}
                onChange={onChange}
                placeholder={placeholder}
                ranges={predefinedBottomRanges}
            />
            <div className="invalid-feedback">
                {error}
            </div>
        </>
    )
}

export default InputDate
