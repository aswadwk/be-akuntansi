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
}) => {
    return (
        <>
            <label className={`form-label ${isRequired ? "required" : ""}`}>
                {label}
            </label>
            <NumericFormat
                className={`form-control ${error ? "is-invalid" : ""}`}
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
            <div className="invalid-feedback">{error}</div>
        </>
    );
};

export default InputNumber;
