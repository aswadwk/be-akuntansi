import React from "react";
import { NumericFormat } from "react-number-format";

export const InputNumber = ({
    label,
    onChange,
    error,
    value,
    placeholder,
    isRequired,
    prefix,
    suffix,
    borderError = true,
}) => {
    return (
        <>
            {label && (
                <label className={`form-label ${isRequired ? 'required' : ''}`}>{label}</label>
            )}
            <NumericFormat
                className={`form-control ${error && borderError ? "is-invalid" : ""}`}
                thousandSeparator={","}
                decimalSeparator="."
                allowNegative={false}
                allowLeadingZeros={false}
                placeholder={placeholder}
                prefix={prefix}
                decimalScale={2}
                value={value}
                onChange={onChange}
                suffix={suffix}
            />
            {error && !borderError && (
                <div className="invalid-feedback">{error}</div>
            )}
            <div className="" style={{ fontSize: '12px', color: '#d63939', marginTop: '.25rem' }}>{error}</div>
        </>
    );
};

export default InputNumber;
